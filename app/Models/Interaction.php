<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interaction extends Model
{
    /** @use HasFactory<\Database\Factories\InteractionFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_id',
        'datetime',
        'type',
        'notes',
    ];

    public function scopeFilter($query, array $filters)
    {
        //filter by cusotmer name
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->whereHas('customer', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        });

        //filter by type
        $query->when($filters['type'] ?? null, function ($query, $type) {
            $query->where('type', '=', $type);
        });

        //filter by date
        $query->when($filters['date'] ?? null, function ($query, $date) {
            $start = Carbon::parse($date)->startOfDay();
            $end = Carbon::parse($date)->endOfDay();

            $query->whereBetween('datetime', [$start, $end]);
        });

        //filter by staff's name
        $query->when($filters['staff'] ?? null, function ($query, $staff) {
            $query->whereHas('staff', function ($q) use ($staff) {
                $q->where('name', 'like', '%' . $staff . '%');
            });
        });

        // filter start_date and end_date
        $query->when($filters['start_date'] ?? null, function ($query, $start) {
            $query->where('datetime', '>=', Carbon::parse($start)->startOfDay());
        });

        $query->when($filters['end_date'] ?? null, function ($query, $end) {
            $query->where('datetime', '<=', Carbon::parse($end)->endOfDay());
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
