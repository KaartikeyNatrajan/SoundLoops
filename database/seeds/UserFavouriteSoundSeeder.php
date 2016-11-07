<?php

use Illuminate\Database\Seeder;

class UserFavouriteSoundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userCount = count(\App\User::all());
        $soundCount = count(\App\Sound::all());

        for($i = 0; $i < 50; $i++)
        {
        	$userId = rand(1, $userCount);
        	$soundId = rand(1, $soundCount);

        	$sound = \App\Sound::find($soundId);

        	$user = \App\User::find($userId);
        	
        	$user->favourites()->toggle($sound);
        }
    }
}
