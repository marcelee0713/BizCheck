<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialLink extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'platform',
        'link',
    ];

    protected static function booted()
    {
        static::creating(function ($socialLink) {
            if (!$socialLink->id) {
                $socialLink->id = (string) Str::uuid();
            }
        });
    }

    public function profile()
    {
        return $this->belongsTo(UserProfile::class);
    }
}
