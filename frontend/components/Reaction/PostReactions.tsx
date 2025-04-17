import { useEffect, useState } from 'react'

import { Heart, HeartBroken, HeartBrokenFilled, HeartFilled } from '#/icons/Misc'
import { countBy } from '#/lib/countBy'
import { client } from '#/lib/fetch'
import { useSessionStore } from 'zustand/session'

import { PostReaction } from './PostReaction'

import style from './postReactions.module.scss'

type Props = {
    pid: number
    reactions: Reaction[]
}

export const PostReactions: React.FC<Props> = ({ pid, reactions }) => {
    const userId = useSessionStore(state => state.user.id)
    const [reacted, setReacted] = useState<'upvote' | 'downvote'>()
    const [counts, setCounts] = useState({
        upvotes: countBy(reactions, 'type', 'upvote'),
        downvotes: countBy(reactions, 'type', 'downvote'),
    })
    const [isDisabled, setIsDisabled] = useState(false)

    useEffect(
        () => setReacted(reactions.find(reaction => reaction.user_id === userId)?.type),
        [reactions, userId]
    )

    const handleReaction: React.MouseEventHandler<HTMLButtonElement> = async ({
        currentTarget,
    }) => {
        const type = currentTarget.name as ReactionType

        setIsDisabled(true)
        const { status } = await client.post(`/posts/${pid}/reactions`, { type })
        setIsDisabled(false)

        if (status === 204) {
            setCounts(prev => ({
                upvotes: type === 'upvote' ? prev.upvotes - 1 : prev.upvotes,
                downvotes: type === 'downvote' ? prev.downvotes - 1 : prev.downvotes,
            }))
            return setReacted(undefined)
        }

        type === 'upvote'
            ? setCounts(prev => ({
                  upvotes: prev.upvotes + 1,
                  downvotes: reacted === 'downvote' ? prev.downvotes - 1 : prev.downvotes,
              }))
            : setCounts(prev => ({
                  upvotes: reacted === 'upvote' ? prev.upvotes - 1 : prev.upvotes,
                  downvotes: prev.downvotes + 1,
              }))
        setReacted(type)
    }

    return (
        <aside className={style.container}>
            <div className={style.reactions}>
                <PostReaction
                    name="upvote"
                    Icon={reacted === 'upvote' ? HeartFilled : Heart}
                    count={counts.upvotes}
                    disabled={isDisabled}
                    onClick={handleReaction}
                />
                <PostReaction
                    name="downvote"
                    Icon={reacted === 'downvote' ? HeartBrokenFilled : HeartBroken}
                    count={counts.downvotes}
                    disabled={isDisabled}
                    onClick={handleReaction}
                />
                {/* <PostReaction Icon={ThreeDotsHorizontal} onClick={() => null} /> */}
            </div>
        </aside>
    )
}
