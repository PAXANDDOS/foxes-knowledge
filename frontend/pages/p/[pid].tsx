import { PostAside } from '@/Asides/PostAside'
import { PageLayout } from '@/Layouts/PageLayout'
import { PostBlock } from '@/Post/PostBlock'
import { PostReactions } from '@/Reaction/PostReactions'

import { client } from '#/lib/fetch'
import { withSessionSsr } from '#/lib/session'
import type { NextPage } from 'next'

import style from 'styles/pages/post.module.scss'

type Props = {
    session: Session
    post: Post
}

const Post: NextPage<Props> = ({ session, post }) => {
    return (
        <PageLayout title={post.title} session={session} className={style.homePage}>
            <div className={style.pageContainer}>
                <PostReactions pid={post.id} reactions={post.reactions as Reaction[]} />
                <PostBlock post={post} />
                <PostAside post={post} />
            </div>
        </PageLayout>
    )
}

export const getServerSideProps = withSessionSsr(async ({ req, params }) => {
    if (!req.session.token) {
        return {
            redirect: {
                permanent: false,
                destination: '/guest',
            },
        }
    }

    const { data } = await client.get<Post>(`/posts/${params!.pid}`, {
        headers: {
            Authorization: `${req.session.token.type} ${req.session.token.value}`,
        },
    })

    return {
        props: {
            session: req.session,
            post: data,
        },
    }
})

export default Post
