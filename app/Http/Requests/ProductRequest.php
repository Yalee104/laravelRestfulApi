<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
             *  NOTE2:  The rules applies as a whole shown below, for example, 'price' must be integer and the minimum is 0
             *          while maximum is 10000. WARNING: if say integer rule is removed from price, it becomes character! so minumum
             *          now becomes at least 0 character and does not exceed 10000 character!!! (not numeric value).
             *  NOTE3:  "unique" rule is validation in a given database table, in this case product table which the name of the product must be unique
             */
            'name' => 'required|max:255|unique:products',
            'description' => 'required',
            'price' => 'required|integer|min:0|max:10000',
            'stock' => 'required|integer|min:0|max:1000',
            'discount' => 'required|integer|min:0|max:30',

        ];
    }
}
