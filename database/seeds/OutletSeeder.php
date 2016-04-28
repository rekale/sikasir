<?php

use Illuminate\Database\Seeder;
use Sikasir\V1\User\Company;
use Sikasir\V1\Outlets\Discount;
use Sikasir\V1\Outlets\Tax;
use Sikasir\V1\Transactions\Payment;
use Sikasir\V1\Outlets\Outlet;
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
    	$businessField = [];
    	
        $businessField[] = BusinessField::create([
            'name' => 'F&B',
        ])->id;
        $businessField[] = BusinessField::create([
            'name' => 'Retail',
        ])->id;
        $businessField[] = BusinessField::create([
            'name' => 'Komoditas',
        ])->id;
        
        
        //create an outlet for every company
        Company::all()->each(function($company) use ($businessField){
                
                //create tax for each company
                $taxes = factory(Tax::class, 3)->create([
                    'company_id' => $company->id,
                ]);
                
                //create discount
                factory(Discount::class, 3)->create([
                    'company_id' => $company->id,
                ]);
                
                //create payment
                factory(Payment::class)->create([
                    'company_id' => $company->id,
                    'name' => 'Tunai',
                ]);
                
                //create payment
                factory(Payment::class)->create([
                    'company_id' => $company->id,
                    'name' => 'Kredit',
                ]);                
        });
        
        $company = Company::findOrFail(1);
        
        //create outlet for each company and add tax
        $outlets = factory(Outlet::class, 3)->create([
        		'company_id' => $company->id,
        		'tax_id' => $company->taxes->random()->id,
        		'business_field_id' => $businessField[mt_rand(0, 2)],
        ]);
        
        //lists created employees id
         
        $owner = $company->users()->where('title', '=', 'owner')->lists('id');
         
        //add employees to every outlets
        foreach ($outlets as $outlet) {
        	$employees = $company->users()->where('title', '<>', 'owner')->get()->random(100)->lists('id');
        	 
        	$outlet->users()->attach($employees->toArray());
        	$outlet->users()->attach($owner->toArray());
        }
    }
}
