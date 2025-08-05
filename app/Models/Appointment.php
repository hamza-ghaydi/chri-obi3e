<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Appointment extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'property_id',
        'client_id',
        'owner_id',
        'appointment_date',
        'status',
        'client_message',
        'owner_response',
        'confirmed_at',
        'rejected_at',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'confirmed_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];
    // * Relations

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

     public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now());
    }
}
