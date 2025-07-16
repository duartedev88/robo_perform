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
        'price',
        'posted',
    ];
}
