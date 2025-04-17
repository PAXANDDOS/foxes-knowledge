import Link from 'next/link'

import { PostTrackerList } from '@/Post/PostTrackerList'
import { TagList } from '@/Tag/TagList'
import { UserPostItem } from '@/User/UserPostItem'

import style from './postItem.module.scss'

type Props = {
    post: Post
}

export const PostItem: React.FC<Props> = ({ post }) => (
    <article className={style.postItem}>
        <UserPostItem user={post.user} postDate={post.created_at} />

        <h1 className={style.postTitle}>
            <Link href={`/p/${post.id}`}>{post.title}</Link>
        </h1>

        <TagList tags={post.tags} />

        <PostTrackerList post={post} />
    </article>
)
