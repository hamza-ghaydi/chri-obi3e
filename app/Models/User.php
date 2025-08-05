<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'profile_picture',
        'contact_info',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }


    // ila kan user (admin)
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // ila kan user (owner)
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }
    // ila kan user (client)
    public function isClient(): bool
    {
        return $this->role === 'client';
    }


    // relation 

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'client_id');
    }

     public function clientAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }

    public function ownerAppointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'owner_id');
    }

    public function appointments(): HasMany
    {
        
        if ($this->role === 'owner') {
            return $this->hasMany(Appointment::class, 'owner_id');
        } else {
            return $this->hasMany(Appointment::class, 'client_id');
        }
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'owner_id');
    }
}
