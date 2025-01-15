<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'image_path', 'condition_id', 'title', 'brand', 'description', 'price', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function orders()
    {
        return $this->hasOne(Order::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getImagePathAttribute($value)
    {
        return $value ?? 'default-item.jpg' ;
    }

}
