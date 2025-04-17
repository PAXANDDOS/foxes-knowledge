import { useRef, useState } from 'react'
import style from './index.module.scss'

type Props = {
    content: string
    delay?: number
    position?: 'top' | 'right' | 'bottom' | 'left'
    disabled?: boolean
    children: React.ReactNode
}

export const Tooltip: React.FC<Props> = ({ children, content, delay, position, disabled }) => {
    let timeout: NodeJS.Timeout
    const [active, setActive] = useState(false)
    const ref = useRef<HTMLDivElement>(null)

    const showTip = () => {
        timeout = setTimeout(() => {
            setActive(true)
        }, delay)
    }

    const hideTip = () => {
        clearInterval(timeout)
        if (!ref.current) return

        const transform = {
            top: 'translateX(-50%) translateY(15%)',
            right: 'translateX(-15%) translateY(-50%)',
            bottom: 'translateX(-50%) translateY(-15%)',
            left: 'translateX(15%) translateY(-50%)',
        }[position!]

        ref.current.animate(
            [{ opacity: 1 }, { opacity: 0.5 }, { opacity: 0, transform: transform }],
            {
                delay: delay! / 2,
                duration: 100,
                fill: 'forwards',
            }
        ).onfinish = () => setActive(false)
    }

    return (
        <div className={style.container} onMouseEnter={showTip} onMouseLeave={hideTip}>
            {children}
            {!disabled && active && (
                <div className={style.tooltip} data-position={position} ref={ref}>
                    {content}
                </div>
            )}
        </div>
    )
}

Tooltip.defaultProps = {
    delay: 400,
    position: 'bottom',
    disabled: false,
}
