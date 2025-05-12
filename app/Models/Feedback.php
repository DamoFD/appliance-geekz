<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'ai_usage_id',
        'feedback',
    ];

    public function aiUsage()
    {
        return $this->belongsTo(AiUsage::class);
    }
}
