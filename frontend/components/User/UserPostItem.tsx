import { SimpleImage } from '@/SimpleImage/SimpleImage'
import dayjs from 'dayjs'
import Image from 'next/image'
import Link from 'next/link'

import style from './userPostItem.module.scss'

type Props = {
    user: User
    postDate: string
}

export const UserPostItem: React.FC<Props> = ({ user, postDate }) => (
    <Link href={`/u/${user.username}`}>
        <div className={style.author}>
            <picture className={style.imageContainer}>
                {user.picture ? (
                    <Image src={user.picture!} alt="user_picture" width={32} height={32} />
                ) : (
                    <SimpleImage username={user.username} color={user.color} />
                )}
            </picture>

            <div className={style.infoContainer}>
                <strong>{user.name}</strong>
                <span>{dayjs(postDate).format('D MMM')}</span>
            </div>
        </div>
    </Link>
)
