<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'locations_name',
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
}
