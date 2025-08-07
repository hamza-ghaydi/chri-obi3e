<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Property extends Model
{
    //

    protected $fillable = [
        'owner_id',
        'category_id',
        'city_id',
        'title',
        'description',
        'price',
        'listing_type',
        'status',
        'address',
        'latitude',
        'longitude',
        'bedrooms',
        'bathrooms',
        'area',
        'featured_image',
        'features',
        'is_featured',
        'payment_completed',
        'approved_at',
        'published_at',
        'admin_notes',
        'rejected_at',
        'reviewed_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'features' => 'array',
        'is_featured' => 'boolean',
        'payment_completed' => 'boolean',
        'approved_at' => 'datetime',
        'published_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // * Relations

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    
    public function getFeaturedImageUrlAttribute(): string
    {
        // First, try to use the featured_image field
        if ($this->featured_image) {
            return Storage::url($this->featured_image);
        }

        // If no featured_image, try to use the first image from the images relationship
        $firstImage = $this->images()->where('is_featured', true)->first()
                   ?? $this->images()->orderBy('sort_order')->first();

        if ($firstImage) {
            return Storage::url($firstImage->image_path);
        }

        // Fallback to placeholder
        return 'https://via.placeholder.com/400x300?text=No+Image';
    }

    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, '.', ',') . ' MAD';
    }

    // * check ila kanet property published and available for contact
    public function isPublished(): bool
    {
        return $this->status === 'approved' &&
               $this->published_at !== null;
    }

    // * check ila kanet property available
    public function isAvailable(): bool
    {
        return in_array($this->status, ['approved']) &&
               !in_array($this->status, ['sold', 'rented']);
    }

    // * check ila kanet property for sale
    public function isForSale(): bool
    {
        return $this->listing_type === 'sale';
    }

    // * check ila kanet property for rent
    public function isForRent(): bool
    {
        return $this->listing_type === 'rent';
    }


    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('status', 'approved')
                    ->where('payment_completed', true);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByListingType($query, $type)
    {
        return $query->where('listing_type', $type);
    }

    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }

        if ($max) {
            $query->where('price', '<=', $max);
        }

        return $query;
    }
}
