<?php

namespace App\Http\Requests\CityManager;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCityManagerRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => "required|email|unique:users,email,$this->id,id",
            // 'avatar_image' => 'image|mimes:jpeg,jpg|max:2048',
        ];
    }
    public function messages()
    {
        return[
            'name.required' => 'name is required!',
            'email.required' => 'email is required!',
            'email.email' => 'email must be valid!',
            'email.unique' => 'email must be unique!',
            // 'avatar_image.image' => 'this file must be image!',
            // 'avatar_image.mimes' => 'image must be jpeg or jpg!',
            // 'avatar_image.max' => 'image maxmum size is 2M!',
        ];
    }
    
}
