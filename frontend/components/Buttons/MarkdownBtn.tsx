import style from './iconBtn.module.scss'

type Props = {
    name: MarkdownType
    Icon: React.ElementType
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const MarkdownBtn: React.FC<Props> = ({ name, Icon, onClick }) => (
    <button
        type="button"
        name={name}
        aria-label={`Markdown ${name}`}
        className={style.iconBtn}
        onClick={onClick}
    >
        <Icon />
    </button>
)
