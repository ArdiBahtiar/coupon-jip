<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = [
        'id',
        'batch_id',
        'box_number',
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

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}
