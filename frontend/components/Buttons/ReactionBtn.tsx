import { capitalizeFirstChar } from '#/lib/capitalizeFirstChar'
import style from './reactionBtn.module.scss'

type Props = {
    title?: string
    name: string
    number: number
    Icon: React.ElementType
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const ReactionBtn: React.FC<Props> = props => (
    <button name={props.name} onClick={props.onClick} className={style.reactionBtn}>
        <props.Icon width={20} />
        {props.number > 0 ? (
            <span>{`${props.number} ${props.name}s`}</span>
        ) : (
            <span>{props.title || capitalizeFirstChar(props.name)}</span>
        )}
    </button>
)
