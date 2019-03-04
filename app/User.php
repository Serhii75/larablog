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
     * Get the user comments
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the user followers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follows_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Get other users who's being followed by the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function follows()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'follows_id')
            ->withTimestamps();
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

    /**
     * Start following the given user
     *
     * @param  \App\User $user
     * @return \App\User
     */
    public function follow($user)
    {
        $this->follows()->attach($user->id);

        return $this;
    }

    /**
     * Stop following the given user
     *
     * @param  \App\user $user
     * @return \App\User
     */
    public function unfollow($user)
    {
        $this->follows()->detach($user->id);

        return $this;
    }

    /**
     * Determine if the user is following other user
     *
     * @param  \App\User  $user
     * @return boolean
     */
    public function isFollowing($user)
    {
        return $this->follows()->contains($user);
    }

    /**
     * Determine if the user is followed by other user
     * @param  \App\User  $user
     * @return boolean
     */
    public function isFollowedBy($user)
    {
        return $this->followers()->contains($user);
    }
}
