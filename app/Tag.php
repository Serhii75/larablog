<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class)->latest();
    }

    public function saveManyFromString($str)
    {
        return array_map(function ($item) {
            $name = trim($item);
            return $this->firstOrCreate(['name' => $name]);
        }, explode(',', $str));
    }
}
