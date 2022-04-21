<?php

namespace App\Http\Requests\Gym;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGymRequest extends FormRequest
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
            'name' => 'required|unique:gyms,name,'.$this->id,
            'city_id' => 'required|exists:cities,id'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.unique' => 'The name has already been taken.',
            'city_id.required' => 'The city field is required.',
            'city_id.exists' => 'The city is invalid.'
        ];
    }
}
