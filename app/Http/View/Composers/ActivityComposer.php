<?php 

namespace App\Http\View\Composers;

use App\Post;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ActivityComposer
{	
	public function compose(View $view)
	{
		$posts = Cache::remember('posts', now()->addMinutes(5), function() {
            return Post::with(['user', 'image'])->orderBy('created_at', 'desc')->get();
        });

        $mostCommentedPosts = Cache::remember('mostCommentedPosts', now()->addMinutes(5), function() {
            return Post::select('id', 'title')->mostCommentedPosts()->take(7)->get();
        });

        $mostActiveUsers = Cache::remember('mostActiveUsers', now()->addMinutes(5), function() {
            return User::select('name')->mostActiveUsers()->take(7)->get();
        });

        $data = array();
        $data['posts'] = $posts;
        $data['mostCommentedPosts'] = $mostCommentedPosts;
        $data['mostActiveUsers'] = $mostActiveUsers; 

        $view->with('data', $data);
	}
}