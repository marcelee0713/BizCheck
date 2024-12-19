<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evaluations extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function ($evaluation) {
            if (!$evaluation->id) {
                $evaluation->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->belongsTo(Submissions::class);
    }

    public function responses()
    {
        return $this->hasMany(Responses::class);
    }
}
