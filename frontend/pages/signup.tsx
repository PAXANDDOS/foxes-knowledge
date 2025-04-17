import type { NextPage } from 'next'
import { useRouter } from 'next/router'
import { useState } from 'react'

import { InputSubmit } from '@/Inputs/InputSubmit'
import { LabeledInput } from '@/Inputs/LabeledInput'
import { PageLayout } from '@/Layouts/PageLayout'

import { Logo } from '#/icons/Brand'
import { client } from '#/lib/fetch'
import { withSessionSsr } from '#/lib/session'
import { useToast } from '#/modules/Toaster'

import style from 'styles/pages/auth.module.scss'

const SignUp: NextPage = () => {
    const router = useRouter()
    const { promise } = useToast()
    const [credentials, setCredentials] = useState({
        username: '',
        name: '',
        email: 'preparedemail@mail.com',
        password: '',
        password_confirmation: '',
    })

    const handleChange: React.ChangeEventHandler<HTMLInputElement> = ({ target }) =>
        setCredentials({ ...credentials, [target.name]: target.value })

    const handleSubmit: React.FormEventHandler = e => {
        e.preventDefault()
        promise({
            title: 'Signing up...',
            promise: client.post('/api/signup', credentials),
            onSuccess: () => router.push('/'),
        })
    }

    return (
        <PageLayout title="Sign up" className={style.authPage} mode="informative">
            <div className={style.authBlock}>
                <div className={style.logoBlock}>
                    <Logo />
                    <h1 className={style.logoHeading}>
                        Welcome to the <strong>Knowledge</strong>!
                    </h1>
                </div>
                <form onSubmit={handleSubmit}>
                    <LabeledInput
                        value={credentials.username}
                        name="username"
                        onChange={handleChange}
                    />
                    <LabeledInput value={credentials.name} name="name" onChange={handleChange} />
                    <LabeledInput
                        value={credentials.email}
                        name="email"
                        disabled={true}
                        onChange={handleChange}
                    />
                    <LabeledInput
                        type="password"
                        value={credentials.password}
                        name="password"
                        onChange={handleChange}
                    />
                    <LabeledInput
                        type="password"
                        value={credentials.password_confirmation}
                        name="password_confirmation"
                        label="Confirm your password"
                        onChange={handleChange}
                    />
                    <InputSubmit label="Sign up" />
                </form>
            </div>
        </PageLayout>
    )
}

export const getServerSideProps = withSessionSsr(({ req }) => {
    if (!!req.session.user) {
        return {
            redirect: {
                permanent: false,
                destination: '/',
            },
        }
    }

    return {
        props: {},
    }
})

export default SignUp
