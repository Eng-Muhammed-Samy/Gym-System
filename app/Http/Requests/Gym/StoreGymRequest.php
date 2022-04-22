<?php

namespace App\Http\Requests\Gym;

use Illuminate\Foundation\Http\FormRequest;

class StoreGymRequest extends FormRequest
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
            'name' => 'required|unique:gyms',
            'city_id' => 'required|exists:cities,id',
            'gym_managers' => 'required|array|min:1|max:3',
            // 'city_manager_id' => 'required|
            // exists:users,id,role,city_manager|
            // exists:cities,city_manager_id,id,'.$this->city_id,
            // 'coverimage' => 'required|image|mimes:jpeg,jpg|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
            'city_id.required' => 'The city field is required.',
            'city_id.exists' => 'The city is invalid.',
            // 'city_manager_id.required' => 'The city manager field is required.',
            // 'city_manager_id.exists' => 'The city manager is invalid.', 
            'gym_managers' => 'you must add at least one gym    manager.',
            'gym_managers.min' => 'you must add at least one gym manager.',
            'gym_managers.max' => 'you can add a maximum of 3 gym managers.',
            // 'coverimage.required' => 'The cover image is required.',
            // 'coverimage.image' => 'The cover image must be an image.',
            // 'coverimage.mimes' => 'The cover image must be a file of type: jpeg, jpg.',
            // 'coverimage.max' => 'The cover image may not be greater than 2M.',
        ];
    }
}
