<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Sound::class, function (Faker\Generator $faker) {
    
    $noOfUsers = count(\App\User::all());
    return [
    	'userId' => rand(1, $noOfUsers),
        'data' => makeJson()
    ];
});

function makeJson()
{
	$jsonObject = new stdClass;
	$jsonObject->drums = [];
	$jsonObject->bass = [];
	
	// 1 - 5 drum tracks
	$number = rand(1, 5);
	$startTime = 0.0;

	for ($i = 0; $i < $number; $i++)
	{ 
		$object = new stdClass;
		
		$object->track = rand(1, 5);
		
		$object->startTime = $startTime;
		$object->endTime = $object->startTime + rand(1, 3) * 4.8;

		$startTime = $object->endTime + rand(0, 3) * 4.8;

		$jsonObject->drums[] = $object;
	}

	// 1 - 5 bass tracks
	$number = rand(1, 5);
	$startTime = 0.0;
	for ($i = 0; $i < $number; $i++)
	{ 
		$object = new stdClass;
		
		$object->track = rand(1, 5);
		
		$object->startTime = $startTime;
		$object->endTime = $object->startTime + rand(1, 3) * 4.8;

		$startTime = $object->endTime + rand(0, 3) * 4.8;

		$jsonObject->bass[] = $object;
	}

	return json_encode($jsonObject);
}