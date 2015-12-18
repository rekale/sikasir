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

use Sikasir\V1\User\Admin;
use Sikasir\V1\User\Owner;
use Sikasir\V1\User\User;
use Sikasir\V1\User\Employee;
use Sikasir\V1\User\Cashier;

use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Tax;

use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Category;
use Sikasir\V1\Products\Variant;

use Sikasir\V1\Stocks\Stock;
use Sikasir\V1\Stocks\StockDetail;
use Sikasir\V1\Stocks\StockEntry;
use Sikasir\V1\Stocks\StockOut;
use Sikasir\V1\Stocks\StockTransfer;

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

$factory->define(Tax::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'amount' => $fake->numberBetween(1, 20),
    ];
});

$factory->define(Admin::class, function (Faker\Generator $fake) {
  
    return [
        'name' => $fake->name,
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

$factory->define(Tax::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'amount' => $fake->numberBetween(1, 20),
    ];
});

$factory->define(Employee::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name,
        'title' => $fake->randomElement(['staff', 'manager']),
        'gender' => $fake->randomElement(['male', 'female']),
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(300, 200, 'people'),
        'void_access' => true,
    ];
    
});

$factory->define(Cashier::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name, 
        'gender' => $fake->randomElement(['male', 'female']),
        'phone' => $fake->phoneNumber,
        'address' => $fake->address,
        'icon' => $fake->imageUrl(),
    ];
});

$factory->define(Customer::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name,
        'email' => $fake->email, 
        'sex' => $fake->randomElement(['male', 'female']), 
        'phone' => $fake->phoneNumber, 
        'address' => $fake->address, 
        'city' => $fake->city, 
        'pos_code' => $fake->postcode,
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

$factory->define(StockDetail::class, function(Faker\Generator $fake) {
    return [
        'total' => $fake->numberBetween(1, 100),
    ];
});
$factory->define(StockEntry::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'total' => $fake->numberBetween(1, 100),
    ];
});
$factory->define(StockOut::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'total' => $fake->numberBetween(1, 100),
    ];
});
$factory->define(StockTransfer::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'total' => $fake->numberBetween(1, 100),
    ];
});
