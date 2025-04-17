import { capitalizeFirstChar } from '#/lib/capitalizeFirstChar'
import style from './labeledInput.module.scss'

interface Props {
    label?: string
    type?: React.HTMLInputTypeAttribute
    name: string
    value: string | number
    onChange: React.ChangeEventHandler<HTMLInputElement>
    required?: boolean
    disabled?: boolean
    min?: string | number
    max?: string | number
    step?: string | number
}

export const LabeledInput: React.FC<Props> = props => (
    <label className={style.labeledInput}>
        {props.label || capitalizeFirstChar(props.name)}
        <input
            type={props.type}
            name={props.name}
            value={props.value}
            onChange={props.onChange}
            required={props.required}
            disabled={props.disabled}
            min={props.min}
            max={props.max}
            step={props.step}
            data-cy={props.name}
        />
    </label>
)

LabeledInput.defaultProps = {
    label: undefined,
    type: 'text',
    required: false,
    disabled: false,
}
