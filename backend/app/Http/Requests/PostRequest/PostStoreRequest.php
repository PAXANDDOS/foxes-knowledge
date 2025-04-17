<?php

namespace App\Http\Requests\PostRequest;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'title' => 'required|string|max:64',
            'content' => 'required|string|max:65500',
            'user_id' => 'integer|exists:users,id',
            'tag_ids' => 'required|array',
            'post_id' => 'integer|unique:posts,id|exists:posts,id',
            'attachments.*' => 'max:8096',
        ];
    }
}
