<?php

namespace App\Services;

use App\Models\Post;

class PostService
{
    public function create(array $data): Post
    {
        $post = Post::create($data);

        $post->tags()->attach($data['tag_ids']);
        $post->save();

        if (isset($data['attachments'])) {
            $this->uploadAttachments($post, $data['attachments']);
        }

        return $post;
    }

    public function update(array $data, Post $post): Post
    {
        if (isset($data['attachments'])) {
            $this->uploadAttachments($post, $data['attachments']);
            unset($data['attachments']);
        }

        if (isset($data['tag_ids'])) {
            $post->tags()->attach($data['tag_ids']);
            $post->save();
        }

        $post->update($data);

        return $post;
    }

    /**
     * @param  Post  $post
     * @param  \Illuminate\Http\UploadedFile[]  $attachments
     */
    public function uploadAttachments($post, $attachments): void
    {
        $files = [];

        foreach ($attachments as $file) {
            $original = $file->getClientOriginalName();
            $filename = pathinfo($original, PATHINFO_FILENAME);
            $filename = $post->id.str($filename)->slug().'-'.time();
            $extension = pathinfo($original, PATHINFO_EXTENSION);
            $picturePath = $file->storeAs('attachments', "$filename.$extension");

            $files[]['file'] = \Illuminate\Support\Facades\Storage::url((string) $picturePath);
        }

        $post->attachments()->createMany($files);
    }
}
