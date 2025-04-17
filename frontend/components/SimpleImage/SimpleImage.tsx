import invertColor from '#/lib/color'
import classes from './simpleImage.module.scss'

type Props = {
    username: string
    color: string
    style?: React.CSSProperties
}

export const SimpleImage: React.FC<Props> = ({ username, color, style }) => (
    <picture
        style={{
            userSelect: 'none',
            background: color,
            borderRadius: '30px',
            color: invertColor(color, {
                black: '#3a3a3a',
                white: '#fafafa',
                threshold: 0.28439059,
            }),
            ...style,
        }}
        className={classes.simpleImage}
    >
        <span>{username.substring(0, 2).toUpperCase()}</span>
    </picture>
)
