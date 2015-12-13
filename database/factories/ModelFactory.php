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
use Sikasir\V1\User\Cashier;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Employee;
use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Variant;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(BusinessField::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
    ];
});

$factory->define(Owner::class, function (Faker\Generator $fake) {
  
    return [
        'name' => $fake->name,
        'business_name' => $fake->company, 
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(), 
        'active' => true,
    ];
});

$factory->define(Outlet::class, function (Faker\Generator $fake) {
    return [
        'owner_id' => null,
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


$factory->define(Employee::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name,
        'title' => $fake->randomElement(['staff', 'manager']),
        'gender' => $fake->randomElement(['pria', 'wanita']),
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(300, 200, 'people'),
        'void_access' => true,
    ];
    
});

$factory->define(Cashier::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name, 
        'gender' => $fake->randomElement(['pria', 'wanita']),
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(),
    ];
});

$factory->define(Category::class, function(Faker\Generator $fake) {
    return [
        'name' => $fake->word,
    ];
    
});

$factory->define(Product::class, function(Faker\Generator $fake) {
    return [
        'name' => $fake->word, 
        'description' => $fake->paragraph(),
        'barcode' => $fake->numerify(),
        'unit' => $fake->word,
        'icon' => $fake->imageUrl(300, 200),
    ];
    
});

$factory->define(Variant::class, function(Faker\Generator $fake) {
    
    return [
        'name' => $fake->word, 
        'code' => $fake->numerify(), 
        'price' => $fake->numberBetween(100, 100000), 
        'track_stock' => $fake->boolean(),
        'stock' => $fake->numberBetween(1, 100),
        'alert' => $fake->boolean(),
        'alert_at' => $fake->numberBetween(1, 30),
    ];
    
});
