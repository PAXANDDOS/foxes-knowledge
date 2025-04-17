import { withSessionSsr } from '#/lib/session'
import { PostEditor } from '@/Editor/PostEditor'
import { PageLayout } from '@/Layouts/PageLayout'

import type { NextPage } from 'next'

import style from 'styles/pages/new.module.scss'

const New: NextPage<{ session: Session }> = ({ session }) => {
    return (
        <PageLayout title="New Post" session={session} className={style.newPostPage}>
            <div className={style.pageContainer}>
                <PostEditor />
            </div>
        </PageLayout>
    )
}

export const getServerSideProps = withSessionSsr(async ({ req }) => {
    if (!req.session.token) {
        return {
            redirect: {
                permanent: false,
                destination: '/guest',
            },
        }
    }
    return {
        props: {
            session: req.session,
        },
    }
})

export default New
