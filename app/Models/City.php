<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class City extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'state',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($city) {
    //         if (empty($city->slug)) {
    //             $city->slug = Str::slug($city->name);
    //         }
    //     });

    //     static::updating(function ($city) {
    //         if ($city->isDirty('name') && empty($city->slug)) {
    //             $city->slug = Str::slug($city->name);
    //         }
    //     });
    // }


    // * Relations

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
