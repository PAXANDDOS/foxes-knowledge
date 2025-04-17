import { UserPost } from '@/User/UserPost'
import style from './rightAside.module.scss'

type Props = {
    post: Post
}

export const PostAside: React.FC<Props> = ({ post }) => (
    <aside className={style.aside}>
        <div className={style.sticky}>
            <UserPost user={post.user} />
        </div>
    </aside>
)
