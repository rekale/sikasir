<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class TaxDiscountRequest extends Request
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
        return [
            'name' => 'required|max:15',
            'amount' => 'required|integer',
        ];
    }
}
