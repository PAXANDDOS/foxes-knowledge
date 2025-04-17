declare type Session = {
    user?: User
    token?: Token
}

declare type Token = {
    type: string
    value: string
    ttl: number
}
