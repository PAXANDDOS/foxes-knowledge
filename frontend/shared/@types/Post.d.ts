declare interface Post extends Entity {
    user: User
    title: string
    content: string
    tags: Tag[]
    reactions: Reaction[] | ReactionCount | number
    comments: Comment[] | number
    attachments: Attachment[] | number
    parent?: Post
    child?: Post
}
