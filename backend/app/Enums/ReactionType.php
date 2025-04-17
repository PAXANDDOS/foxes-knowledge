<?php

namespace App\Enums;

enum ReactionType: string
{
    case UPVOTE = 'upvote';
    case DOWNVOTE = 'downvote';

    public static function values(): array
    {
        return array_map(function ($case) {
            return $case->value;
        }, self::cases());
    }
}
