<?php

use Illuminate\Database\Seeder;

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
        
        Sikasir\User\Owner::all()->each(function($owner) use ($fake){
        
            foreach (range(1, rand(2, 5)) as $i) {
                
                $owner->outlets()->save(new Sikasir\Outlet([
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
        
        Sikasir\Outlet::all()->each(function($outlet)
        {
            //attach  employees to outlet that have not outlet 
            $outlet->employees()->saveMany(
                    \Sikasir\User\Employee::whereOutletId(null)
                    ->take(rand(1,2))->get()
            );
            
        });
    }
}
