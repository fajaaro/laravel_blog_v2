<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(App\User::class)->states('user-fajar')->create();
        factory(App\User::class, 20)->create();
    }
}