import style from './iconBtn.module.scss'

type Props = {
    name: string
    active?: boolean
    Icon: React.ElementType
    onClick: React.MouseEventHandler<HTMLButtonElement>
    title?: string
}

export const IconBtn: React.FC<Props> = props => (
    <button
        type="button"
        name={props.name}
        onClick={props.onClick}
        aria-label={`Icon ${props.name}`}
        className={style.iconBtn}
        title={props.title}
        data-active={props.active}
    >
        <props.Icon />
    </button>
)

IconBtn.defaultProps = {
    active: false,
}
