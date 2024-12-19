<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Competitors extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($competitor) {
            if (!$competitor->id) {
                $competitor->id = (string) Str::uuid();
            }
        });
    }

    public function submission()
    {
        return $this->belongsTo(Submissions::class);
    }
}
