import style from './userInfoTag.module.scss'

type Props = {
    title: string
    Icon?: React.ElementType
    content: string
}

export const UserInfoTag: React.FC<Props> = ({ title, Icon, content }) => (
    <div className={style.infoTag}>
        <h3 className={style.title}>{title.toUpperCase()}</h3>
        <span className={style.content}>{content}</span>
    </div>
)
