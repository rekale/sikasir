<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class InventoryRequest extends Request
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
        $rules = [
            'user_id' => 'required',
            'note' => 'max:255',
            'input_at' => 'required|date',
            'status' => 'boolean',
        ];
        
        $variants = $this->input('variants');
        
        if(isset($variants)) {
            
            $tot = count($variants) - 1;
            foreach(range(0, $tot) as $key) {
              $rules['variants.' .$key . '.id'] = 'required|max:255';
              $rules['variants.' .$key . '.total'] = 'required|integer';              
            }
        
        }
        
        return $rules;
    }
}
