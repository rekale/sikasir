<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\BusinessField;

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
        Sikasir\V1\User\Owner::all()->each(function($owner) use ($fake, $businessField){

            foreach (range(1, rand(2, 5)) as $i) {

                $owner->outlets()->save(new \Sikasir\V1\Outlets\Outlet([
                    'name' => $fake->word,
                    'code' => $fake->numerify(),
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
        Sikasir\V1\Outlets\Outlet::all()->each(function($outlet)
        {
            //attach  employees to outlet that have not outlet
            $outlet->employees()->attach(
                Sikasir\V1\User\Employee::all()->random()
            );

        });
    }
}
