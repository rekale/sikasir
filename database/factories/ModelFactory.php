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

use Sikasir\V1\User\User;
use Sikasir\V1\User\Company;

use Sikasir\V1\Outlets\Outlet;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Customer;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Outlets\Printer;

use Sikasir\V1\Products\Product;
use Sikasir\V1\Products\Variant;
use Sikasir\V1\Products\Category;

use Sikasir\V1\Stocks\Entry;
use Sikasir\V1\Stocks\Out;
use Sikasir\V1\Stocks\Opname;
use Sikasir\V1\Stocks\PurchaseOrder;

use Sikasir\V1\Orders\Order;
use Sikasir\V1\Orders\Void;
use Sikasir\V1\Orders\Debt;

use Sikasir\V1\Suppliers\Supplier;
use Sikasir\V1\Transactions\Payment;


$factory->define(Company::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->word,
        'address' => $faker->address, 
        'phone' => $faker->phoneNumber, 
        'icon' => $faker->imageUrl(300, 200, 'people'),
        'active' => $faker->boolean(),
        'password' => bcrypt(str_random(10)),
    ];
});

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'title' => $faker->randomElement(['kasir', 'manager', 'owner']), 
        'gender' => $faker->randomElement(['male', 'female']),
        'address' => $faker->address, 
        'phone' => $faker->phoneNumber, 
        'icon' => $faker->imageUrl(300, 200, 'people'),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(BusinessField::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
    ];
});

$factory->define(Outlet::class, function (Faker\Generator $fake) {
    return [
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

$factory->define(Discount::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'amount' => $fake->numberBetween(1, 20),
    ];
});

$factory->define(Payment::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'description' => $fake->words(3, true),
    ];
});

$factory->define(Tax::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'amount' => $fake->numberBetween(1, 20),
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

$factory->define(Supplier::class, function (Faker\Generator $fake) {
    return [
        'name' => $fake->name,
        'email' => $fake->email, 
        'phone' => $fake->phoneNumber, 
        'address' => $fake->address, 
     ];
});

$factory->define(Category::class, function(Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'description' => $fake->words(3, true),
    ];
    
});

$factory->define(Product::class, function(Faker\Generator $fake) {
    return [
        'name' => $fake->word, 
        'description' => $fake->paragraph(),
        'unit' => $fake->word,
        'icon' => $fake->imageUrl(300, 200),
    ];
    
});

$factory->define(Variant::class, function(Faker\Generator $fake) {
    return [
        'name' => $fake->word,
        'barcode' => $fake->numerify(),
        'price_init' => $fake->numberBetween(100, 10000),  
        'price' => $fake->numberBetween(10000, 100000), 
        'countable' => $fake->boolean(), 
        'track_stock' => $fake->boolean(),
        'stock' => $fake->numberBetween(1, 100),
        'alert' => $fake->boolean(),
        'alert_at' => $fake->numberBetween(1, 30),
        'icon' => $fake->imageUrl(300, 200),
    ];
    
});

$factory->define(Entry::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'input_at' => $fake->date(),
    ];
});
$factory->define(Out::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'input_at' => $fake->date(),
    ];
});
$factory->define(Opname::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'input_at' => $fake->date(),
        'status' => $fake->boolean(),
    ];
});
$factory->define(PurchaseOrder::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'input_at' => $fake->date(),
        'po_number' => $fake->numerify(),
    ];
});

$factory->define(Order::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
        'no_order' => $fake->numerify(),
    ];
});

$factory->define(Void::class, function(Faker\Generator $fake) {
    return [
        'note' => $fake->words(5, true),
    ];
});

$factory->define(Debt::class, function(Faker\Generator $fake) {
    return [
        'due_date' => $fake->date(),
        'total' => $fake->numberBetween(1000, 1000000),
        'paid_at' => $fake->date(),
    ];
});

$factory->define(Printer::class, function(Faker\Generator $fake) {
    return [
        'code' => $fake->numerify(),
        'name' => $fake->word,
        'logo' => $fake->imageUrl(300, 200),
        'address' => $fake->address,
        'info' => $fake->words(5, true),
        'footer_note' => $fake->words(5, true),
        'size' => $fake->randomElement([1 , 2]),
    ];
});
