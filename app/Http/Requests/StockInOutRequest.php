<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class StockInOutRequest extends Request
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
        $rules = [];
        
        $entries = $this->input('entries');
        
        $tot = count($entries) - 1;
        
        foreach(range(0, $tot) as $key)
        {
          $rules['entries.' .$key . '.id'] = 'required';
          $rules['entries.' .$key . '.input_at'] = 'date|required';
          $rules['entries.' .$key . '.note'] = 'max:255|required';
          $rules['entries.' .$key . '.total'] = 'numeric|min:0|required';
        }
        
        return $rules;
    }
}
