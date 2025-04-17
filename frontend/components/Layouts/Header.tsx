import Link from 'next/link'

import { HeaderDropdown } from '@/Dropdowns/HeaderDropdown'

import { Logo } from '#/icons/Brand'
import { Search } from '#/icons/Misc'
import style from './header.module.scss'

export const Header: React.FC<{ user: User }> = ({ user }) => (
    <header className={style.header}>
        <div className={style.headerContainer}>
            <Link href="/">
                <figure className={style.headerLogo}>
                    <Logo height={46} />
                    <figcaption>Knowledge</figcaption>
                </figure>
            </Link>
            <div className={style.searchbar}>
                <input type="text" title="Enter your query" placeholder="" />
                <button type="submit" title="Search">
                    <Search width={24} />
                </button>
            </div>
            <div className={style.userBlock}>
                <Link href={'/new'}>
                    <a className={style.createBtn}>Create post</a>
                </Link>
                <HeaderDropdown user={user} />
            </div>
        </div>
    </header>
)
