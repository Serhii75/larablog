<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'description', 'live',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->latest();
    }
}
