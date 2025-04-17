<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'username' => 'required|string|max:16',
            'name' => 'string|max:32',
            'email' => 'required|string|max:256|unique:users,email',
            'password' => 'required|string|max:256|confirmed',
            'token' => 'required|string|exists:invitations,token',
        ];
    }
}
