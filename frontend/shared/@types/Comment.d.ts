declare interface Comment extends Entity {
    user: User
    post: Post
    content: string
    reactions: Reaction[]
}
