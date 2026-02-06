<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:8'],
            'last_name'  => ['required', 'string', 'max:8'],
            'gender'     => ['required'],
            'email'      => ['required', 'email', 'max:255'],
            'tel1'       => ['required', 'numeric', 'digits_between:1,5'],
            'tel2'       => ['required', 'numeric', 'digits_between:1,5'],
            'tel3'       => ['required', 'numeric', 'digits_between:1,5'],
            'address'    => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'detail'     => ['required', 'string', 'max:120'],
        ];
    }
}
