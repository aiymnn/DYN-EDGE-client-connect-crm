<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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

        // filter by role
        $query->when($filters['role'] ?? null, function ($query, $role) {
            $query->where('role', '=', $role);
        });

        // filter by created_at
        $query->when($filters['start_date'] ?? null, function ($query, $start) {
            $query->whereDate('created_at', '>=', $start);
        });

        $query->when($filters['end_date'] ?? null, function ($query, $end) {
            $query->whereDate('created_at', '<=', $end);
        });

        // filter by status 
        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status === 'active') {
                $query->whereNull('deleted_at');
            } elseif ($status === 'inactive') {
                $query->whereNotNull('deleted_at');
            }
        });
    }

    public function isAdmin()
    {
        return $this->role === 'R01';
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
