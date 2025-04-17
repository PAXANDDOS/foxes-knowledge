import Image from 'next/image'
import dayjs from 'dayjs'
import Link from 'next/link'

import { SimpleImage } from '@/SimpleImage/SimpleImage'
import { UserInfoTag } from './UserInfoTag'
import style from './userPost.module.scss'

type Props = {
    user: User
}

export const UserPost: React.FC<Props> = ({ user }) => (
    <section className={style.userBlock}>
        <div
            style={{
                width: '100%',
                height: '2rem',
                background: user.color,
            }}
        />
        <Link href={`/u/${user.username}`}>
            <figure className={style.user}>
                <div className={style.image}>
                    {user.picture ? (
                        <Image src={user.picture!} alt="user_picture" width={80} height={25} />
                    ) : (
                        <SimpleImage username={user.username} color={user.color} />
                    )}
                </div>
                <figcaption className={style.name}>{user.name}</figcaption>
            </figure>
        </Link>
        <div className={style.bio}>{user.bio}</div>
        <div className={style.tags}>
            <UserInfoTag title="Joined" content={dayjs(user.created_at).format('MMM D, YYYY')} />
        </div>
    </section>
)
