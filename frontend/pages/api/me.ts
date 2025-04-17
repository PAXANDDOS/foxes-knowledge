import { withSessionRoute } from '#/lib/session'
import { NextApiHandler } from 'next'

const signOut: NextApiHandler = async (req, res) => {
    const raw = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/me`, {
        method: 'GET',
        headers: {
            Authorization: `${req.session.token.type} ${req.session.token.value}`,
        },
    })

    res.status(raw.status).json(await raw.json())
}

export default withSessionRoute(signOut)
