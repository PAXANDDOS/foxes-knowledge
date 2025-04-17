declare interface Reaction extends Entity {
    user_id: number
    post_id?: number
    comment_id?: number
    type: ReactionType
}

declare interface ReactionCount {
    upvote: number
    downvote: number
}

declare type ReactionType = 'upvote' | 'downvote'
