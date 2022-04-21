<?php

namespace App\Http\Requests\CityManager;

use Illuminate\Foundation\Http\FormRequest;

class StoreCityManagerRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'avatar_image' => 'nullable|image|mimes:jpeg,jpg|max:2048',
            'city_id' => 'required|exists:cities,id,city_manager_id,NULL'
        ];
    }
    public function messages()
    {
        return[
            'avatar_image.image' => 'this file must be image!',
            'avatar_image.mimes' => 'image must be jpeg or jpg!',
            'avatar_image.max' => 'image maxmum size is 2M!',
            'city_id.required' => 'city is required!',
            'city_id.id' => 'city not found!',
            'city_id.city_manager_id' => 'city already have manager!',
        ];
    }
}
