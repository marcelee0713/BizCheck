<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use CrudTrait;
    use HasFactory, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_first_time',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'profile'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_first_time' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->id) {
                $user->id = (string) Str::uuid();
            }
        });
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submissions::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluations::class);
    }
}
