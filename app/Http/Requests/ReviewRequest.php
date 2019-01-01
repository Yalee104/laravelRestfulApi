<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            /*  Aaron
             *  NOTE1:  A list of available rules is described in https://laravel.com/docs/5.7/validation#available-validation-rules
             *  NOTE2:  For more detail refer to ProductRequest.php
             */
            'description' => 'nullable|max:255',
            'rating' => 'required|integer|min:0|max:5'
        ];
    }
}
