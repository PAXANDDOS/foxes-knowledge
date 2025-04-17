import style from './inputSubmit.module.scss'

interface Props {
    label?: string
    style?: React.CSSProperties
}

export const InputSubmit: React.FC<Props> = props => (
    <input className={style.inputSubmit} type="submit" value={props.label} style={props.style} />
)

InputSubmit.defaultProps = {
    label: 'Submit',
}
