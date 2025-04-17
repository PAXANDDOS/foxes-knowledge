<?php

namespace App\Services;

use App\Enums\ReactionType;
use App\Models\Comment;

class CommentService
{
    /**
     * @return Comment|Comment[] $comments
     */
    public function getWithReactions(Comment $comment = null)
    {
        if ((bool) $comment) {
            return $this->withReactions($comment);
        }

        /**
         * @var Comment[] $comments
         */
        $comments = [];
        foreach (Comment::all() as $item) {
            $comments[] = $this->withReactions($item);
        }

        return $comments;
    }

    public function withReactions(Comment $comment): Comment
    {
        $copy = Comment::find($comment->id);

        $counts = [];
        foreach (ReactionType::cases() as $type) {
            $counts["reactions as {$type->value}"] = fn ($query) => $query->where('type', $type->value);
        }

        $copy->loadCount($counts);

        $comment->reactions = array_filter(
            $copy->toArray(),
            fn ($value, $key) => in_array($key, ReactionType::values()),
            ARRAY_FILTER_USE_BOTH
        );

        return $comment->load(['user', 'post']);
    }
}
