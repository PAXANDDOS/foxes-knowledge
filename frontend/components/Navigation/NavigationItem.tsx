import Link from 'next/link'
import { useRouter } from 'next/router'

import style from './navigation.module.scss'

type Props = {
    emoji: string
    label: string
    to: string
}

export const NavigationItem: React.FC<Props> = ({ emoji, label, to }) => {
    const router = useRouter()

    return (
        <>
            {router.pathname === to ? (
                <li className={style.navItem} data-cy={to}>
                    {emoji} <span>{label}</span>
                </li>
            ) : (
                <Link href={to} passHref>
                    <li className={style.navItem} data-cy={to}>
                        {emoji} <span>{label}</span>
                    </li>
                </Link>
            )}
        </>
    )
}
