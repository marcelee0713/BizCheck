<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Metrics extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'value',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($metric) {
            if (!$metric->id) {
                $metric->id = (string) Str::uuid();
            }
        });
    }

    public function submission()
    {
        return $this->belongsTo(Submissions::class);
    }
}
