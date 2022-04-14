<?php

namespace App\Http\Requests\Gym_Members;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Date;

use Illuminate\Validation\Rule;

class StoreGym_MembersRequest
{
    public function authorize()
    {
        return true;
    }
    public static function getRules()
    {
        return [
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'name' => ['required', 'min:3'],
            'password' => ['required_with:password_confirmed', Password::min(8)],
            'password_confirmed' => 'min:8|required|same:password',
            'avatar_image' => ['nullable','image','mimes:png,jpg,jpeg', 'max:2048', 'unique:users'],
            'gender' => ['required', Rule::in(['male', 'female', 'Male', 'Female'])],
            'date_of_birth' => ['required', 'date', 'before:now'],
        ];
    }
    public static function getMessages()
    {
        return [
            'email.required' => 'An email is required',
            'email.unique' => 'An email must be unique',
            'name.required' => 'A name is required ',
            'name.min' => 'A name must be more than 3 characters',
            'avatar_image.mimes' => 'An avatar_image extension must be jpg or jpeg only',
            'password.min' => 'A password must at least 8 characters',
            'password.confirmed' => 'password is not equal',

        ];
    }
    
}
