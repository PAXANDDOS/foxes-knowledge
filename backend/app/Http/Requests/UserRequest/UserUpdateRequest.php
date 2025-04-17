<?php

namespace App\Http\Requests\UserRequest;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'string|max:16',
            'name' => 'string|max:32',
            'email' => 'string|max:64|unique:users,email',
            'password' => 'string|max:64',
            'isEmailPublic' => 'boolean',
            'picture' => 'image|mimes:png,jpg,jpeg|max:4096',
            'bio' => 'string|max:200',
            'color' => 'string|max:7',
        ];
    }
}
