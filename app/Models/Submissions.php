<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Submissions extends Model
{
    use CrudTrait;
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
        return $this->hasMany(Objectives::class, 'submission_id');
    }

    public function metrics()
    {
        return $this->hasMany(Metrics::class, 'submission_id');
    }

    public function insights()
    {
        return $this->hasMany(Insights::class, 'submission_id');
    }

    public function competitors()
    {
        return $this->hasMany(Competitors::class, 'submission_id');
    }

    public function challenges()
    {
        return $this->hasMany(Challenges::class, 'submission_id');
    }

    public function evaluations()
    {
        return $this->belongsTo(Evaluations::class, 'submission_id');
    }
}
