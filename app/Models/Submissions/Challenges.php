<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Challenges extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'input',
    ];

    protected static function booted()
    {
        static::creating(function ($challenge) {
            if (!$challenge->id) {
                $challenge->id = (string) Str::uuid();
            }
        });
    }

    public function submission()
    {
        return $this->belongsTo(Submissions::class);
    }
}
