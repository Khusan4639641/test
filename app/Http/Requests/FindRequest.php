<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FindRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // TODO check with authorized users
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
            'name'      => 'sometimes|required|string|max:100',
            'price.x'   => 'sometimes|required|numeric',
            'price.y'   => 'sometimes|required|numeric', //use both (sometimes|required) for situation not null
            'bathrooms' => 'sometimes|required|integer',
            'bedrooms'  => 'sometimes|required|integer',
            'storeys'   => 'sometimes|required|integer',
            'garages'   => 'sometimes|required|integer',
        ];
    }
}
