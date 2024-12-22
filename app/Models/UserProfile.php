<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class UserProfile extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
      'business_name',
      'business_model',
      'industry',
      'description',
      'target_audience',
      'unique_selling_point',
      'location',
      'phone_number',
      'website_url'
    ];

    protected static function booted()
    {
        static::creating(function ($profile) {
            if (!$profile->id) {
                $profile->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }
}
