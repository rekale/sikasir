<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class OrderRequest extends Request
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
            'customer_id' => 'max:255',
            'note' => 'max:255',
        ];

        $variants = $this->input('variants');

        $tot = count($variants) - 1;

        foreach(range(0, $tot) as $key) {

        $rules['variants.' .$key . '.id'] = 'required';
        $rules['variants.' .$key . '.quantity'] = 'required|integer';
        $rules['variants.' .$key . '.weight'] = 'required|numeric';
        $rules['variants.' .$key . '.price'] = 'required|integer';
        $rules['variants.' .$key . '.nego'] = 'required|integer';
        $rules['variants.' .$key . '.discount_by_product'] = 'required|integer';

        }

        return $rules;
    }
}
