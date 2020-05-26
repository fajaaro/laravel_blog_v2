<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability) {
        if ($user->is_admin === 1) return true;
    }

    public function create(User $user)
    {
        return $user->id > 0;
    }

    public function view(User $user)
    {
        return $user->id > 0;
    }

    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function restore(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }

    public function forceDelete(User $user, Post $post)
    {
        return $user->id === $post->user_id;        
    }

    public function addComment(User $user)
    {
        return $user->id > 0;
    }
}
