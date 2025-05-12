<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiUsage extends Model
{
    protected $fillable = [
        'prompt',
        'model',
        'response',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
