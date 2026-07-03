<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'id',
        'coupon_number',
        'prize',
        'box_id',
        'remarks',
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

    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }
}
