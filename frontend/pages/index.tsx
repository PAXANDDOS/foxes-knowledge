import { withSessionSsr } from '#/lib/session'
import { PageLayout } from '@/Layouts/PageLayout'
import { NavigationBar } from '@/Navigation/NavigationBar'

import { client } from '#/lib/fetch'
import { queryBuilder } from '#/lib/queryBuilder'
import { HomeAside } from '@/Asides/HomeAside'
import { PostList } from '@/Post/PostList'
import type { NextPage } from 'next'

import style from 'styles/pages/index.module.scss'

type Props = {
    session: Session
    posts: Paginated<Post>
    tags: Tag[]
}

const Home: NextPage<Props> = ({ session, posts, tags }) => {
    return (
        <PageLayout title="Home" session={session} className={style.homePage}>
            <div className={style.pageContainer}>
                <NavigationBar />
                <PostList posts={posts.data} />
                <HomeAside tags={tags} />
            </div>
        </PageLayout>
    )
}

export const getServerSideProps = withSessionSsr(async ({ req, query }) => {
    if (!req.session.token) {
        return {
            redirect: {
                permanent: false,
                destination: '/guest',
            },
        }
    }

    const options = {
        headers: {
            Authorization: `${req.session.token.type} ${req.session.token.value}`,
        },
    }

    const [posts, tags] = await Promise.all([
        client.get<Paginated<Post>>(`/posts${queryBuilder(query)}`, options),
        client.get<Tag[]>('/tags/top', options),
    ])

    return {
        props: {
            session: req.session,
            posts: posts.data,
            tags: tags.data,
        },
    }
})

export default Home
