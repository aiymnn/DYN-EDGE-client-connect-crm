<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'name',
        'id_number',
        'email',
        'phone',
        'address',
        'notes',
    ];

    // filters
    public function scopeFilter($query, array $filters)
    {
        // filter by name
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name', 'like', '%' . $name . '%');
        });

        // filter by email
        $query->when($filters['email'] ?? null, function ($query, $email) {
            $query->where('email', 'like', '%' . $email . '%');
        });

        // filter by phone
        $query->when($filters['phone'] ?? null, function ($query, $phone) {
            $query->where('phone', 'like', '%' . $phone . '%');
        });

        // filter by created_from and created_to
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        } elseif (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        } elseif (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        // filter by status
        if (!empty($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($filters['status'] === 'inactive') {
                $query->onlyTrashed();
            }
        } else {
            $query->withTrashed();
        }
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
