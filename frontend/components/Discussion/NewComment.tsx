import Image from 'next/image'
import { useState } from 'react'

import { SimpleImage } from '@/SimpleImage/SimpleImage'
import ReactTextareaAutosize from 'react-textarea-autosize'
import { useSessionStore } from 'zustand/session'

import style from './newComment.module.scss'

export const NewComment: React.FC = () => {
    const user = useSessionStore(state => state.user)
    const [content, setContent] = useState('')

    const handleSubmit: React.FormEventHandler<HTMLFormElement> = e => {
        e.preventDefault()
    }

    return (
        <form className={style.newComment} onSubmit={handleSubmit}>
            <ReactTextareaAutosize
                cacheMeasurements
                value={content}
                onChange={e => setContent(e.target.value)}
                placeholder="What do you think about this post?"
                className={style.content}
                autoComplete="off"
                aria-label="Comment content"
                required
            />
            <div className={style.buttons}>
                <picture className={style.user}>
                    {user.picture ? (
                        <Image src={user.picture} alt="user_picture" width={35} height={35} />
                    ) : (
                        <SimpleImage username={user.username} color={user.color} />
                    )}
                </picture>
                <input type="submit" value="Comment" className={style.submit} />
            </div>
        </form>
    )
}
