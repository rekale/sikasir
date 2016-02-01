<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class PrinterRequest extends Request
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
            'code' => 'required|max:20',
            'name' => 'required|max:255',
            'logo' => 'required',
            'address' => 'required|max:2000',
            'info' => 'required',
            'footer_note' => 'required',
            'size' => 'required',
        ];
    }
}
