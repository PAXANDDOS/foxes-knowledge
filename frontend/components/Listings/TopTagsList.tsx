import Link from 'next/link'

import style from './topTagsList.module.scss'

const TagObject: React.FC<{ id: number; name: string; posts: number }> = ({ id, name, posts }) => (
    <Link href={`/tags/${id}`}>
        <a>
            <span>#{name}</span>
            <span>{posts}</span>
        </a>
    </Link>
)

export const TopTagsList: React.FC<{ tags: Tag[] }> = ({ tags }) => (
    <article className={style.topTagsList}>
        <div className={style.header}>
            <h2>Top 5 Tags</h2>
            <Link href={'/tags'}>
                <a>See all</a>
            </Link>
        </div>
        <div className={style.content}>
            {tags?.map(tag => (
                <TagObject key={tag.id} id={tag.id} name={tag.name} posts={tag.posts as number} />
            ))}
        </div>
    </article>
)
