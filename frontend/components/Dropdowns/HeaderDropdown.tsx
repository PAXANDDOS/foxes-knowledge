import Image from 'next/image'
import Link from 'next/link'
import { useRouter } from 'next/router'
import { useState } from 'react'

import { client } from '#/lib/fetch'
import { Dropdown } from '#/modules/Dropdown'
import { SimpleImage } from '@/SimpleImage/SimpleImage'
import style from './headerDropdown.module.scss'

type Props = {
    user: User
}

export const HeaderDropdown: React.FC<Props> = ({ user }) => {
    const [rendered, setRendered] = useState(false)
    const router = useRouter()

    const handleRender: React.MouseEventHandler<HTMLButtonElement> = () => setRendered(a => !a)

    const handleLogOut: React.MouseEventHandler<HTMLButtonElement> = () =>
        client.post('/api/signout', {}, { local: true }).then(() => router.push('/guest'))

    return (
        <Dropdown rendered={rendered} handleRender={handleRender}>
            {rendered && (
                <ul className={style.dropdown}>
                    <li className={style.dropdownItem}>
                        <Link href={`/u/${user.username}`}>
                            <a>
                                <strong>{user.name}</strong>
                                <br />
                                <small>@{user.username.toLocaleLowerCase()}</small>
                            </a>
                        </Link>
                    </li>
                    <li className={style.dropdownItem}>
                        <Link href={'/new'}>
                            <a>Create Post</a>
                        </Link>
                    </li>
                    <li className={style.dropdownItem}>
                        <Link href={'/account'}>
                            <a>Settings</a>
                        </Link>
                    </li>
                    <li className={style.dropdownItem}>
                        <button onClick={handleLogOut}>Sign Out</button>
                    </li>
                </ul>
            )}
            <button className={style.headerUser} onClick={handleRender}>
                {user.picture ? (
                    <Image src={user.picture} alt="profile_picture" />
                ) : (
                    <SimpleImage
                        username={user.username}
                        color={user.color}
                        style={{ padding: 10 }}
                    />
                )}
            </button>
        </Dropdown>
    )
}
