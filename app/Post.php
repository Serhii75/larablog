<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image',
        'body',
        'live',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category for the post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the post tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * The the post comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
     * Get all of the post's likes
     *
     * @return [type] [description]
     */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * Scope a query to include post preview data
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePreviews($query)
    {
        return $query->with('tags', 'user.role')->withCount('comments')->withCount('likes');
    }

    /**
     * Save tags from string and syncronize them with the post
     *
     * @param  string $str [tags separated by commas]
     * @return void
     */
    public function saveTagsFromString($str)
    {
        $tags = collect(explode(',', $str))->map(function ($item) {
            $name = trim($item);
            return Tag::firstOrCreate(['name' => $name]);
        });

        $this->tags()->sync($tags->pluck('id')->toArray());
    }

    public function getIntroAttribute()
    {
        $filtered = strip_tags($this->body);
        $length = config('larablog.posts.intro_length');

        return mb_strlen($filtered) > $length ? mb_substr($filtered, 0, $length) . '...' : $filtered;
    }
}
