import create from 'zustand'

interface Store {
    user: User
    token: Token
    setSession: (session: Session) => void
}

export const useSessionStore = create<Store>()(set => ({
    user: {
        id: 0,
        username: '',
        name: '',
        email: '',
        isEmailPublic: false,
        picture: '',
        bio: '',
        color: '#000000',
        created_at: '',
        updated_at: '',
    },
    token: <Token>{},
    setSession: session => set(() => ({ user: session.user, token: session.token })),
}))
