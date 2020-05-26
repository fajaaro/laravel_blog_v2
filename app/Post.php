<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Post extends Model
{
    use softDeletes;

    protected $fillable = ['user_id', 'title', 'content'];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function comments()
    {
    	return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }

    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeDescOrderedPosts($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeMostCommentedPosts(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function(Post $post) {
            $post->comments()->delete();
            
            if ($post->image) $post->image()->delete();
        });

        static::restored(function(Post $post) {
            $post->comments()->onlyTrashed()->restore();

            if ($post->image()->trashed()) $post->image()->onlyTrashed()->restore();
        });
    }
}
