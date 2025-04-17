import Link from 'next/link'
import style from './postTracker.module.scss'

type Props = {
    href?: string
    Icon: React.ElementType
    count: number
    label: string
}

export const PostTracker: React.FC<Props> = ({ href, Icon, count, label }) => (
    <>
        {href ? (
            <Link href={href}>
                <button className={style.linkTracker}>
                    <Icon width={20} /> {`${count} ${label}`}
                </button>
            </Link>
        ) : (
            <span className={style.blockTracker}>
                <Icon width={20} /> {`${count} ${label}`}
            </span>
        )}
    </>
)
