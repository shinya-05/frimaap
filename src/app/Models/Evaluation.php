<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'item_id',
        'evaluator_id',
        'evaluated_id',
        'score',
    ];

    // リレーション（例：評価されたユーザー）
    public function evaluatedUser()
    {
        return $this->belongsTo(User::class, 'evaluated_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}