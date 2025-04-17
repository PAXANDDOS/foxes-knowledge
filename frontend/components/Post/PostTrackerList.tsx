import { BookOpen, Comment, Heart } from '#/icons/Misc'
import { getTextReadingTime } from '#/lib/readingTime'
import { PostTracker } from './PostTracker'

import style from './postTrackerList.module.scss'

type Props = {
    post: Post
}

export const PostTrackerList: React.FC<Props> = ({ post }) => (
    <div className={style.trackerList}>
        <PostTracker
            href={`/p/${post.id}`}
            Icon={Heart}
            count={post.reactions as number}
            label="reactions"
        />
        <PostTracker
            href={`/p/${post.id}`}
            Icon={Comment}
            count={post.comments as number}
            label="comments"
        />
        <PostTracker Icon={BookOpen} count={getTextReadingTime(post.content)} label="min read" />
    </div>
)
