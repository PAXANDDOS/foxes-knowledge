<?php

namespace App\Http\Requests\AttachmentRequest;

use Illuminate\Foundation\Http\FormRequest;

class AttachmentUpdateRequest extends FormRequest
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
            'post_id' => 'integer|exists:posts,id',
            'file' => 'file|max:4096',
        ];
    }
}
