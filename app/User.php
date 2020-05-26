<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_admin'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeMostActiveUsers($query)
    {
        return $query->withCount('posts')->withCount('comments')->has('comments', '>', 0)->orderBy('posts_count', 'desc')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // ketika user di delete (soft delete), postnya juga akan di delete (soft delete)
        static::deleting(function(User $user) {
            $user->posts()->delete();

            if ($user->image) $user->image()->delete();
        });

        // ketika user di delete (force delete), postnya juga akan di delete (force delete)        
        static::deleted(function(User $user) {
            $user->posts()->forceDelete();
        });

        // ketika user di restore, postnya juga akan di restore                
        static::restoring(function(User $user) {
            $user->posts()->restore();

            if ($user->image()->trashed()) $user->image()->onlyTrashed()->restore();
        });
    }
}
