<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('role', $role)->exists();
    }

    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('role', (array) $roles)->exists();
    }

    public function surveyMitras()
    {
        return $this->hasMany(SurveyMitra::class, 'user_id');
    }

    public function mitrasDiawasi()
    {
        return Mitra::whereHas('surveys', function($query) {
            $query->whereHas('mitras', function($q) {
                $q->where('user_id', $this->id);
            });
        })->get();
    }

    public function getRoleNamesAttribute()
    {
        return $this->roles->pluck('role')->implode(', ');
    }

}
