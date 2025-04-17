interface Capitalizer {
    (chars: string | string[], locale?: string): string
}

/**
 * Capitalize the first character of a string
 * @param {string | string[]} chars The string or array of strings to capitalize
 * @param {string} locale The locale to use for capitalization
 * @returns {string} The capitalized string
 * @example
 * capitalizeFirstChar('hello') // 'Hello'
 * capitalizeFirstChar('hello', 'de') // 'Hallo'
 * capitalizeFirstChar(['hello', 'world']) // ['Hello', 'World']
 **/
export const capitalizeFirstChar: Capitalizer = ([first, ...rest], locale = 'en-US') =>
    first.toLocaleUpperCase(locale) + rest.join('')
