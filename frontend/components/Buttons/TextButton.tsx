import style from './textBtn.module.scss'

type Props = {
    name: string
    content: string
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const TextBtn: React.FC<Props> = props => (
    <button
        type="button"
        name={props.name}
        onClick={props.onClick}
        aria-label={`Button ${props.name}`}
        className={style.textBtn}
        style={{ margin: 0 }}
    >
        {props.content}
    </button>
)
