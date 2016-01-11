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
        return [
            'customer_id' => 'max:255',
            'operator_id' => 'required|max:255',
            'note' => 'max:255',
            'total' => 'required|numeric',
            'paid' => 'boolean',
        ];
    }
}
