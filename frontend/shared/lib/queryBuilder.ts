import type { ParsedUrlQuery } from 'querystring'

/**
 * Generates a query string from a query object.
 * @param {ParsedUrlQuery} query The query object.
 * @returns The query string.
 * @example queryBuilder({ order: 'latest' }) // '?order=created_at,desc'
 */
export const queryBuilder = (query: ParsedUrlQuery): string => {
    if (Object.keys(query).length === 0) {
        return '?order=created_at,desc'
    }

    let queryString = '?'

    for (let key in query) {
        if (key === 'order')
            switch (query[key]) {
                case 'latest':
                    query[key] = 'created_at,desc'
                    break
                case 'oldest':
                    query[key] = 'created_at,asc'
                    break
                case 'top':
                    query[key] = 'reactions,desc'
                    break
            }
        queryString += `${key}=${query[key]}&`
    }

    return queryString.slice(0, -1)
}
