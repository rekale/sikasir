<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\Outlets\BusinessField;
use Sikasir\V1\Outlets\Outlet;

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

        $businessField[] = BusinessField::create([
            'name' => 'F&B',
        ]);
        $businessField[] = BusinessField::create([
            'name' => 'Retail',
        ]);
        $businessField[] = BusinessField::create([
            'name' => 'Komoditas',
        ]);

        //create an outlet for every owner
        Sikasir\V1\User\Owner::all()->each(function($owner) use ($fake, $businessField){

                $outlets = factory(Outlet::class, 3)->make([
                    'business_field_id' => $fake->randomElement(
                        [$businessField[0]->id,$businessField[1]->id,$businessField[2]->id]
                    ),
                ]);
                
                $owner->outlets()->saveMany($outlets);
                
                $employees = $owner->employees->lists('id');
                
                $owner->outlets->each(function ($outlet) use ($employees) {
                    
                    $outlet->employees()->attach($employees->toArray());
                    
                });
        });
        
    }
}
