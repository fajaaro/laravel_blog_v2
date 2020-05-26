<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
    	$flag = $this->command->confirm('Mau buat post untuk user tertentu?');

    	if ($flag) {
    		$id = (int)$this->command->ask('Input ID user: ', 1);

    		$user = App\User::findOrFail($id);

    		$this->command->info('User bernama ' . $user->name . '.');

    		$banyakPost = (int)$this->command->ask('Banyak post: ', 5);

    		$user->posts()->createMany(
    			factory(App\Post::class, $banyakPost)->make()->toArray()
    		);

    	} else {
            $banyakPost = (int)$this->command->ask('Banyak post: ', 5);

    		$users = App\User::all();

	        $posts = factory(App\Post::class, $banyakPost)->make()->each(function ($post) use ($users) {
	        	$post->user_id = $users->random()->id;
	        	$post->save();
	        });
    	}
    }
}
