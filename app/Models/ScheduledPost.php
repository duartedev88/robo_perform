<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledPost extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'product_name',
        'description',
        'image_url',
        'caption',
        'scheduled_at',
        'price',
        'posted',
        'posted_at',
    ];
    protected $casts = [
        'scheduled_at' => 'datetime',
        'posted' => 'boolean',
    ];
}
