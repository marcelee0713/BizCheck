<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Submissions extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected static function booted()
    {
        static::creating(function ($submission) {
            if (!$submission->id) {
                $submission->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function objectives()
    {
        return $this->hasMany(Objectives::class);
    }

    public function metrics()
    {
        return $this->hasMany(Metrics::class);
    }

    public function insights()
    {
        return $this->hasMany(Insights::class);
    }

    public function competitors()
    {
        return $this->hasMany(Competitors::class);
    }

    public function challenges()
    {
        return $this->hasMany(Challenges::class);
    }

    public function evaluations()
    {
        return $this->belongsTo(Evaluations::class);
    }
}
