<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'client_id',
        'owner_id',
        'property_id',
        'amount',
        'payment_type',
        'fee_percentage',
        'status',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_session_id',
        'stripe_subscription_id',
        'stripe_response',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_percentage' => 'decimal:2',
        'stripe_response' => 'array',
        'paid_at' => 'datetime',
    ];

    // * Relations

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function getFormattedAmountAttribute(): string
    {
        return number_format($this->amount, 2, '.', ',') . ' MAD';
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    

    // ! maybe i ddon't neeed this
    public function isMonthlyRent(): bool
    {
        return $this->payment_type === 'monthly_rent';
    }

    public function isFullPurchase(): bool
    {
        return $this->payment_type === 'full_purchase';
    }
}
