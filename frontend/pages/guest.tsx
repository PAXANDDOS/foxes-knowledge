import { Logo } from '#/icons/Brand'
import { PageLayout } from '@/Layouts/PageLayout'
import type { NextPage } from 'next'
import Link from 'next/link'
import style from 'styles/pages/guest.module.scss'

const Guest: NextPage = () => (
    <PageLayout title="Foxes Knowledge" className={style.guestPage} mode="informative">
        <div className={style.logoBlock}>
            <Logo width={256} />
            <h1>Foxes / Knowledge</h1>
        </div>
        <Link href="/signin">
            <a className={style.signBtn}>Sign in</a>
        </Link>
        <div className={style.tipBlock}>
            <h2>You must be invited in order to sign in</h2>
            <span>
                Try asking your friends for an invitation,
                <br />
                if they use this service.
            </span>
        </div>
        <div className={style.faqList}>
            <h1>Frequently Asked Questions 🤔</h1>
            <div className={style.faqBlock}>
                <h2>Why do I need an invitation?</h2>
                <p>
                    This service is aimed for a specific group of people. In order to access it, you
                    must receive an invitation which only can be sent by existing members.
                </p>
            </div>
            <div className={style.faqBlock}>
                <h2>Why do I need an invitation?</h2>
                <p>
                    This service is aimed for a specific group of people. In order to access it, you
                    must receive an invitation which only can be sent by existing members.
                </p>
            </div>
        </div>
    </PageLayout>
)

export default Guest
