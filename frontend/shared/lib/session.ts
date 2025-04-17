import { IronSessionOptions } from 'iron-session'
import { withIronSessionApiRoute, withIronSessionSsr } from 'iron-session/next'
import { GetServerSidePropsContext, GetServerSidePropsResult, NextApiHandler } from 'next'

export const sessionOptions: IronSessionOptions = {
    password: process.env.SECRET_COOKIE_PASSWORD!,
    cookieName: 'iron-session',
    ttl: 4320 * 60,
    cookieOptions: {
        secure: process.env.NODE_ENV === 'production',
    },
}

/**
 * Wraps a Next.js API handler with Iron Session
 * @param {NextApiHandler} handler The handler to wrap
 * @returns {NextApiHandler} The wrapped handler
 */
export const withSessionRoute = (handler: NextApiHandler) => {
    return withIronSessionApiRoute(handler, sessionOptions)
}

/**
 * Wraps a Next.js SSR handler with Iron Session
 * @param {NextApiHandler} handler The handler to wrap
 * @returns The wrapped handler
 */
export function withSessionSsr<P extends { [key: string]: any } = { [key: string]: any }>(
    handler: (
        context: GetServerSidePropsContext
    ) => GetServerSidePropsResult<P> | Promise<GetServerSidePropsResult<P>>
) {
    return withIronSessionSsr(handler, sessionOptions)
}

declare module 'iron-session' {
    interface IronSessionData {
        user: User
        token: Token
    }
}
