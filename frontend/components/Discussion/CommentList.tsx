import { CommentItem } from './CommentItem'
import style from './commentList.module.scss'

type Props = {
    comments: Comment[]
}

export const CommentList: React.FC<Props> = ({ comments }) => (
    <div className={style.comments}>
        {comments.map(comment => (
            <CommentItem key={comment.id} comment={comment} />
        ))}
    </div>
)
