<?php

use Illuminate\Database\Seeder;
use Sikasir\Outlets\BusinessField;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $fake = Faker\Factory::create();

        $businessField = BusinessField::create([
            'name' => 'Foods and Beverages',
        ]);

        //create an outlet for every owner
        Sikasir\User\Owner::all()->each(function($owner) use ($fake, $businessField){

            foreach (range(1, rand(2, 5)) as $i) {

                $owner->outlets()->save(new \Sikasir\Outlets\Outlet([
                    'name' => $fake->word,
                    'business_field_id' => $businessField->id,
                    'address' => $fake->address,
                    'province' => $fake->word,
                    'city'=> $fake->city,
                    'pos_code' => $fake->countryCode,
                    'phone1' => $fake->phoneNumber,
                    'phone2' => $fake->phoneNumber,
                    'icon' => $fake->imageUrl(300, 200, 'people'),
                ]));

            }

        });
        //add employees to every outlets
        Sikasir\Outlets\Outlet::all()->each(function($outlet)
        {
            //attach  employees to outlet that have not outlet
            $outlet->employees()->attach(
                Sikasir\User\Employee::all()->random()
            );

        });
    }
}
