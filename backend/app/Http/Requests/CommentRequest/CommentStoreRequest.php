<?php

namespace App\Http\Requests\CommentRequest;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'post_id' => 'required|integer|exists:posts,id',
            'content' => 'required|string|max:65500',
        ];
    }
}
