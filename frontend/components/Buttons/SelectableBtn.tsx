import { capitalizeFirstChar } from '#/lib/capitalizeFirstChar'
import style from './selectableBtn.module.scss'

type Props = {
    title?: string
    name: string
    selected: boolean
    onClick: React.MouseEventHandler<HTMLButtonElement>
}

export const SelectableBtn: React.FC<Props> = props => (
    <button
        name={props.name}
        x-active={props.selected.toString()}
        onClick={props.onClick}
        className={style.selectableBtn}
    >
        {props.title || capitalizeFirstChar(props.name)}
    </button>
)
