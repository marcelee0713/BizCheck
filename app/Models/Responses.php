<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Responses extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'message',
        'sender'
    ];

    protected static function booted()
    {
        static::creating(function ($response) {
            if (!$response->id) {
                $response->id = (string) Str::uuid();
            }
        });
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluations::class, 'evaluation_id');
    }

}
