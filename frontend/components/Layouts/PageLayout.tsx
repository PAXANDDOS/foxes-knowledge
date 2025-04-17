import Head from 'next/head'
import { useEffect } from 'react'

import { useSessionStore } from 'zustand/session'
import { Header } from './Header'

type Props = {
    title?: string
    className: string
    session?: Session
    children: React.ReactNode
    mode?: 'contentful' | 'informative'
}

export const PageLayout: React.FC<Props> = ({ title, className, session, children, mode }) => {
    const setSession = useSessionStore(state => state.setSession)

    useEffect(() => session && setSession(session!), []) // eslint-disable-line

    return (
        <>
            <Head>
                <title>{title + (mode === 'contentful' ? ' ∣ Foxes Knowledge' : '')}</title>
            </Head>
            {mode === 'contentful' && <Header user={session?.user!} />}
            <div className={className}>{children}</div>
        </>
    )
}

PageLayout.defaultProps = {
    title: 'Foxes Knowledge',
    mode: 'contentful',
}
