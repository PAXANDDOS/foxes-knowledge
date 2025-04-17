import { CommentList } from './CommentList'
import style from './discussion.module.scss'
import { NewComment } from './NewComment'

type Props = {
    comments: Comment[]
}

export const Discussion: React.FC<Props> = ({ comments }) => (
    <section>
        <h2 className={style.discussion}>Discussion ({comments.length})</h2>
        <NewComment />
        <CommentList comments={comments} />
    </section>
)
