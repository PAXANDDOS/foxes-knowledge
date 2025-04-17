declare interface Tag extends Entity {
    name: string
    color: string
    posts: Post[] | number
}
