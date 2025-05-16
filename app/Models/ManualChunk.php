<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualChunk extends Model
{
    protected $fillable = [
        'text',
        'embedding',
        'brand',
        'model',
    ];
}
