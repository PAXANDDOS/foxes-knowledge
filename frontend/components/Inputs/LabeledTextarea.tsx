import { capitalizeFirstChar } from '#/lib/capitalizeFirstChar'
import style from './labeledTextarea.module.scss'

interface Props {
    label?: string
    name: string
    value?: string | number
    onChange: React.ChangeEventHandler<HTMLTextAreaElement>
    required?: boolean
}

export const LabeledTextarea: React.FC<Props> = props => (
    <label className={style.labeledTextarea}>
        {props.label || capitalizeFirstChar(props.name)}
        <textarea
            name={props.name}
            value={props.value}
            onChange={props.onChange}
            data-cy={props.name}
        ></textarea>
    </label>
)

LabeledTextarea.defaultProps = {
    label: undefined,
    required: false,
}
