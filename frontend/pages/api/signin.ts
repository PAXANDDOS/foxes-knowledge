import { withSessionRoute } from '#/lib/session'
import { NextApiHandler } from 'next'

const signIn: NextApiHandler = async (req, res) => {
    const raw = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/signin`, {
        method: req.method,
        headers: { 'Content-Type': req.headers['content-type']! },
        body: JSON.stringify(req.body),
    })
    const json = await raw.json()

    if (raw.status == 200) {
        req.session.user = json.user
        req.session.token = json.token
        await req.session.save()
    }

    res.status(raw.status).json(json)
}

export default withSessionRoute(signIn)
