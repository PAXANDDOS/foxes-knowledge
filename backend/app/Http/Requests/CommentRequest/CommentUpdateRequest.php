<?php

namespace App\Http\Requests\CommentRequest;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
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
            'user_id' => 'integer|exists:users,id',
            'post_id' => 'integer|exists:posts,id',
            'content' => 'string|max:65500',
        ];
    }
}
