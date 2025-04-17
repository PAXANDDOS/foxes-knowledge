import { useRouter } from 'next/router'
import { useState } from 'react'

import { SelectableBtn } from '@/Buttons/SelectableBtn'
import { PostItem } from './PostItem'

import style from './postList.module.scss'

type Props = {
    posts: Post[]
}

type Order = 'latest' | 'top'

export const PostList: React.FC<Props> = ({ posts }) => {
    const router = useRouter()
    const [order, setOrder] = useState<Order>('latest')

    const handleChange: React.MouseEventHandler<HTMLButtonElement> = ({ currentTarget }) => {
        setOrder(currentTarget.name as Order)
        router.push({
            pathname: router.pathname,
            query: { ...router.query, order: currentTarget.name },
        })
    }

    return (
        <div className={style.container}>
            <fieldset className={style.filters}>
                <SelectableBtn name="latest" onClick={handleChange} selected={order === 'latest'} />
                <SelectableBtn name="top" onClick={handleChange} selected={order === 'top'} />
            </fieldset>
            <main className={style.list}>
                {posts.map(post => (
                    <PostItem key={post.id} post={post} />
                ))}
            </main>
        </div>
    )
}
