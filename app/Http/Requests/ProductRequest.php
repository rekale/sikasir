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
        $rulePost =  [
        	'category_id' => 'required',
            'name' => 'required|max:255', 
            'description' => 'required|max:1000', 
            'barcode' => 'max:255', 
            'unit' => 'required|max:10',
            'outlet_ids' => 'required|array',
        ];
        
        $rulePut =  [
            'category_id' => 'required',
            'name' => 'required|max:255', 
            'description' => 'required|max:1000', 
            'barcode' => 'max:255', 
            'unit' => 'required|max:10',
        ];
        
        $rules = $this->method() === 'POST' ? $rulePost : $rulePut;
        
        $variants = $this->input('variants');
        
        if(isset($variants)) {
            
            $tot = count($variants) - 1;
            foreach(range(0, $tot) as $key) {
                
              $rules['variants.' .$key . '.name'] = 'required|max:255';
              $rules['variants.' .$key . '.barcode'] = 'required|max:255';
              $rules['variants.' .$key . '.price_init'] = 'required|integer';
              $rules['variants.' .$key . '.price'] = 'required|integer';
              $rules['variants.' .$key . '.track_stock'] = 'required|boolean';
              $rules['variants.' .$key . '.stock'] = 'required|integer';
              $rules['variants.' .$key . '.alert'] = 'required|boolean';
              $rules['variants.' .$key . '.alert_at'] = 'required|integer';
              
            }
        
        }
        
        return $rules;
        
    }

}
