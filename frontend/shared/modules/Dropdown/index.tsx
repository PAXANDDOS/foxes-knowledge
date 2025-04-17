import { useEffect, useRef } from 'react'
import style from './index.module.scss'

type Props = {
    rendered: boolean
    handleRender: Function
    children: React.ReactNode
}

export const Dropdown: React.FC<Props> = ({ rendered, handleRender, children }) => {
    const ref = useRef<HTMLDivElement>(null)

    useEffect(() => {
        if (!rendered) return

        const handleClickOutside = (ev: any) => !ref.current!.contains(ev.target) && handleRender()
        document.addEventListener('click', handleClickOutside, true)

        return () => document.removeEventListener('click', handleClickOutside, true)
    }, [rendered, handleRender])

    return (
        <div ref={ref} className={style.wrapper}>
            {children}
        </div>
    )
}
