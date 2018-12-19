<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the role for the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Determine if the user is an admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    /**
     * Determine if the user owns the post
     *
     * @param  Post   $post [description]
     * @return boolean
     */
    public function ownsPost(Post $post)
    {
        return $this->id === $post->user->id;
    }

     /**
     * Determine if the user owns the comment
     *
     * @param  Post   $post [description]
     * @return boolean
     */
    public function ownsComment(Comment $comment)
    {
        return $this->id === $comment->user->id;
    }
}
