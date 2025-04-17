import style from './postReaction.module.scss'

type Props = {
    name: ReactionType
    Icon: React.ElementType
    count?: number
    disabled?: boolean
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const PostReaction: React.FC<Props> = ({ name, Icon, count, disabled, onClick }) => (
    <div className={style.reaction}>
        <button
            className={style.button}
            aria-label={name}
            type="button"
            name={name}
            disabled={disabled}
            onClick={onClick}
        >
            <Icon width={24} />
        </button>
        <span className={style.count}>{count}</span>
    </div>
)
