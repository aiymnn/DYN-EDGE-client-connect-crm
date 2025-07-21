<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'customer_id',
        'title',
        'description',
        'status',
        'priority',
    ];

    public function scopeFilter($query, array $filters)
    {
        //filter by cusotmer name
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->whereHas('customer', function ($q) use ($name) {
                $q->where('name', 'like', '%' . $name . '%');
            });
        });

        //filter by status
        $query->when($filters['status'] ?? null, function ($query, $status) {
            $query->where('status', '=', $status);
        });

        //filter by priority
        $query->when($filters['priority'] ?? null, function ($query, $priority) {
            $query->where('priority', '=', $priority);
        });

        //filter by created
        $query->when($filters['created'] ?? null, function ($query, $created) {
            $start = Carbon::parse($created)->startOfDay();
            $end = Carbon::parse($created)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        });

        //filter by staff's name
        $query->when($filters['staff'] ?? null, function ($query, $staff) {
            $query->whereHas('staff', function ($q) use ($staff) {
                $q->where('name', 'like', '%' . $staff . '%');
            });
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
