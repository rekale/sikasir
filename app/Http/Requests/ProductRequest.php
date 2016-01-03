<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class ProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        if ($this->method() === 'POST') {
            return $this->createRules();
        }
        else {
            return $this->updateRules();
        }
        
    }
    
    public function createRules()
    {
        $rules =  [
            'category_id' => 'required',
            'name' => 'required|max:255', 
            'description' => 'required|max:1000', 
            'barcode' => 'required|max:255', 
            'unit' => 'required|max:10',
            'outlet_ids' => 'required|array',
        ];
        
        $variants = $this->input('variants');
        
        $tot = count($variants) - 1;
         foreach(range(0, $tot) as $key)
            {
              $rules['variants.' .$key . '.name'] = 'required|max:255';
              $rules['variants.' .$key . '.code'] = 'required|max:255';
              $rules['variants.' .$key . '.price_init'] = 'required|integer';
              $rules['variants.' .$key . '.price'] = 'required|integer';
              $rules['variants.' .$key . '.track_stock'] = 'required|boolean';
              $rules['variants.' .$key . '.stock'] = 'required|integer';
              $rules['variants.' .$key . '.alert'] = 'required|boolean';
              $rules['variants.' .$key . '.alert_at'] = 'required|integer';
              
            }
        
        return $rules;
        
    }
    
    public function updateRules()
    {
        $rules =  [
            'category_id' => 'required',
            'name' => 'max:255', 
            'description' => 'max:1000', 
            'barcode' => 'max:255', 
            'unit' => 'max:10',
        ];
        
        $variants = $this->input('variants');
        
        $tot = count($variants) - 1;
         foreach(range(0, $tot) as $key)
            {
              $rules['variants.' .$key . '.name'] = 'max:255';
              $rules['variants.' .$key . '.code'] = 'max:255';
              $rules['variants.' .$key . '.price_init'] = 'required|integer';
              $rules['variants.' .$key . '.price'] = 'required|integer';
              $rules['variants.' .$key . '.track_stock'] = 'boolean';
              $rules['variants.' .$key . '.stock'] = 'integer';
              $rules['variants.' .$key . '.alert'] = 'boolean';
              $rules['variants.' .$key . '.alert_at'] = 'integer';
              $rules['variants.' .$key . '.delete'] = 'boolean';
            }
        
        return $rules;
    }
}
