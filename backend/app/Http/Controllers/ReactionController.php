<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReactionRequest\ReactionCommentRequest;
use App\Http\Requests\ReactionRequest\ReactionPostRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    public function reactPost(Post $post, ReactionPostRequest $request): Response
    {
        $userId = Auth::id();
        $type = $request->type;

        $reaction = Reaction::where([
            ['user_id', $userId],
            ['post_id', $post->id],
        ])->first();

        if (! $reaction) {
            return response(Reaction::create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'type' => $type,
            ]), Response::HTTP_CREATED);
        }

        if ($reaction->type->value === $type) {
            Reaction::destroy($reaction->id);

            return response(null, Response::HTTP_NO_CONTENT);
        }

        $reaction->update(['type' => $type]);

        return response($reaction, Response::HTTP_CREATED);
    }

    public function reactComment(Comment $comment, ReactionCommentRequest $request): Response
    {
        $userId = Auth::id();
        $type = $request->type;

        $reaction = Reaction::where([
            ['user_id', $userId],
            ['comment_id', $comment->id],
        ])->first();

        if (! $reaction) {
            return response(Reaction::create([
                'user_id' => $userId,
                'comment_id' => $comment->id,
                'type' => $type,
            ]), Response::HTTP_CREATED);
        }

        if ($reaction->type->value === $type) {
            Reaction::destroy($reaction->id);

            return response(null, Response::HTTP_NO_CONTENT);
        }

        $reaction->update(['type' => $type]);

        return response($reaction, Response::HTTP_CREATED);
    }
}
