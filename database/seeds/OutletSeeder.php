<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

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
        //create an outlet for every owner
        Sikasir\User\Owner::all()->each(function($owner) use ($fake){
        
            foreach (range(1, rand(2, 5)) as $i) {
                
                $owner->outlets()->save(new Sikasir\Outlet([
                    'id' => Uuid::uuid4()->toString(),
                    'name' => $fake->word,
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
        Sikasir\Outlet::all()->each(function($outlet)
        {
            //attach  employees to outlet that have not outlet 
            $outlet->employees()->attach(
                Sikasir\User\Employee::all()->random()
            );
            
        });
    }
}
