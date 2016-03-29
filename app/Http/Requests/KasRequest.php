<?php

namespace Sikasir\Http\Requests;

use Sikasir\Http\Requests\Request;

class KasRequest extends Request
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
			'total' => 'required|numeric',
			'note' => 'required|max:255',
		];
    }
}
