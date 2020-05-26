<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        $users = App\User::all();
        $posts = App\Post::all();

        $banyakComment = (int)$this->command->ask('Mau berapa banyak comment?', 25);

        $flag = $this->command->confirm('Mau buat comment untuk post tertentu?');

        if ($flag) {
            $post_id = (int)$this->command->ask('Post id?');

            $comments = factory(App\Comment::class, $banyakComment)->make()->each(function($comment) use ($users, $post_id) {
            	$comment->post_id = $post_id;
            	$comment->user_id = $users->random()->id;
            	$comment->save();        	
            });            
        } else {
            $comments = factory(App\Comment::class, $banyakComment)->make()->each(function($comment) use ($users, $posts) {
                $comment->post_id = $posts->random()->id;
                $comment->user_id = $users->random()->id;
                $comment->save();           
            });                        
        }

    }
}
