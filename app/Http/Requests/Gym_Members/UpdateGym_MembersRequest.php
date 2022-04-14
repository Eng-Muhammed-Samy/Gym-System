<?php

namespace App\Http\Requests\Gym_Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class UpdateGym_MembersRequest extends FormRequest
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

    public static function getRules($id, $type_of_avatar_image)
    {
        $rules = [];
        // if ($type_of_avatar_image != "string") {
        //     $rules['avatar_image'] = ['mimes:png,jpg,jpeg','required', 'max:2048', 'unique:users'];
        // }
        $rules['email'] = ['email', Rule::unique('users', 'email')->ignore($id, 'id')];
        $rules['name'] = ['required', 'min:3'];
        // $rules['password'] = ['required_with:password_confirmed', Password::min(8)];
        // $rules['password_confirmed'] = 'min:8|required|same:password';
        $rules['gender'] = ['required', Rule::in(['male', 'female', 'Male', 'Female'])];
        // $rules['date_of_birth'] = ['required', 'date', 'before:now'];
        return $rules;
    }

    public static function getMessages()
    {
        return [
            'email.required' => 'An email is required',
            'email.unique' => 'An email must be unique',
            'name.required' => 'A name is required ',
            'name.min' => 'A name must be more than 3 characters',

        ];
    }
}
