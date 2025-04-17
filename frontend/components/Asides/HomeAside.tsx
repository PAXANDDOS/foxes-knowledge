import { TopTagsList } from '@/Listings/TopTagsList'
import style from './rightAside.module.scss'

type Props = {
    tags: Tag[]
}

export const HomeAside: React.FC<Props> = ({ tags }) => (
    <aside className={style.aside}>
        <div className={style.sticky}>
            <TopTagsList tags={tags} />
        </div>
    </aside>
)
