import color from '#/lib/color'
import Link from 'next/link'

import style from './tagItem.module.scss'

type Props = {
    tag: Tag
}

export const TagItem: React.FC<Props> = ({ tag }) => {
    const handleMouseOver = ({ style }: HTMLButtonElement, tag: Tag) => {
        style.background = color.addAlphaHex(tag.color, 0.2)
        style.border = `1px solid ${tag.color}`
    }

    const handleMouseOut: React.MouseEventHandler<HTMLButtonElement> = ({ currentTarget }) => {
        currentTarget.style.background = 'none'
        currentTarget.style.border = '1px solid transparent'
    }

    return (
        <Link key={tag.id} href={`/t/${tag.id}`}>
            <button
                className={style.tagItem}
                onMouseEnter={({ currentTarget }) => handleMouseOver(currentTarget, tag)}
                onMouseLeave={handleMouseOut}
            >
                <small style={{ color: tag.color, fontWeight: 700, marginRight: 2 }}>#</small>
                {tag.name}
            </button>
        </Link>
    )
}
