import { withSessionRoute } from '#/lib/session'
import { NextApiHandler } from 'next'

const signOut: NextApiHandler = async (req, res) => {
    const raw = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/signout`, {
        method: req.method,
        headers: {
            'Content-Type': req.headers['content-type']!,
            Authorization: `${req.session.token.type} ${req.session.token.value}`,
        },
    })

    if (raw.status == 204) {
        req.session.destroy()
    }

    res.status(raw.status).json({})
}

export default withSessionRoute(signOut)
