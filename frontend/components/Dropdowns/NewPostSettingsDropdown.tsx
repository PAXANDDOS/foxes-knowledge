import { useState } from 'react'
import AsyncSelect from 'react-select/async'

import { Settings } from '#/icons/Misc'
import { client } from '#/lib/fetch'
import { Dropdown } from '#/modules/Dropdown'
import { IconBtn } from '@/Buttons/IconBtn'
import { TextBtn } from '@/Buttons/TextButton'

import style from './newPostSettings.module.scss'

type Props = {
    parentState: [Post | null, (post: Post) => void]
}

export const NewPostSettingsDropdown: React.FC<Props> = ({ parentState }) => {
    const [rendered, setRendered] = useState(false)

    const handleRender: React.MouseEventHandler<HTMLButtonElement> = () => setRendered(a => !a)

    const loadPosts = async (search: string) =>
        new Promise<Post[]>(async resolve => {
            const { data } = await client.get<Paginated<Post>>(`/posts?search=${search}`)
            resolve(data.data.map(post => ({ ...post, label: post.title, value: post.id })))
        })

    return (
        <Dropdown rendered={rendered} handleRender={handleRender}>
            {rendered && (
                <div className={style.dropdown}>
                    <h1 className={style.heading}>Post options</h1>
                    <div className={style.block}>
                        <label className={style.title}>Parent post</label>
                        <p className={style.content}>
                            Specify the parent post if this post is part of a series. Series are
                            shown on the Listing page and can be easily navigated within its posts.
                        </p>
                        <AsyncSelect
                            id="posts"
                            instanceId="posts"
                            aria-label="posts"
                            placeholder="Enter parent post title ..."
                            value={parentState[0]}
                            onChange={post => parentState[1](post as Post)}
                            loadOptions={loadPosts}
                        />
                    </div>
                    <TextBtn name="done" content="Done" onClick={handleRender} />
                </div>
            )}
            <IconBtn
                name="options"
                active={rendered}
                Icon={Settings}
                onClick={handleRender}
                title="Options"
            />
        </Dropdown>
    )
}
