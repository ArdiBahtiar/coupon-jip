<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'locations_id',
        'batch_number',
        'started_at',
        'finished_at',
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_at = now()->timezone('Asia/Jakarta');
            $model->updated_at = now()->timezone('Asia/Jakarta');
        });
        static::updating(function ($model) {
            $model->updated_at = now()->timezone('Asia/Jakarta');
        });
    }
  
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'locations_id');
    }
}


