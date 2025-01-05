<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Evaluations extends Model
{
    use HasFactory;
    
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'submission_id',
        'user_id'
    ];

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
        return $this->belongsTo(Submissions::class, 'submission_id');
    }

    public function responses()
    {
        return $this->hasMany(Responses::class, 'evaluation_id');
    }
}
