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

use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\User\Owner;
use Sikasir\V1\Outlets\BusinessField;

$factory->define(Sikasir\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(BusinessField::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name,
    ];
});

$factory->define(Outlet::class, function (Faker\Generator $fake) {
    return [
        'business_field_id' => factory(BusinessField::class)->create()->id,
        'name' => $fake->word,
        'code' => $fake->numerify(),
        'address' => $fake->address,
        'province' => $fake->word,
        'city'=> $fake->city,
        'pos_code' => $fake->countryCode,
        'phone1' => $fake->phoneNumber,
        'phone2' => $fake->phoneNumber,
        'icon' => $fake->imageUrl(300, 200, 'people'),
    ];
});

$factory->define(Owner::class, function (Faker\Generator $fake) {
    return [
        'full_name' => $fake->name, 
        'business_name' => $fake->company, 
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(), 
        'active' => true,
    ];
});