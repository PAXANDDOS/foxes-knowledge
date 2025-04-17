/**
 * Parses a string into a Markdown string using the given Markdown type.
 * @param type The type of Markdown to parse.
 * @param content The content to parse.
 * @returns The parsed Markdown string.
 * @example markdownHandler('ordered-list', 'Hello World') // returns '1. Hello World'
 */
export const markdownHandler = (type: MarkdownType, content = ''): string => {
    switch (type) {
        case 'bold':
            return mdHandleBold(content)
        case 'italic':
            return mdHandleItalic(content)
        case 'code':
            return mdHandleCode(content)
        case 'quote':
            return mdHandleQuote(content)
        case 'link':
            return mdHandleLink(content)
        case 'codeblock':
            return mdHandleCodeBlock(content)
        case 'heading':
            return mdHandleHeading(content)
        case 'ordered-list':
            return mdHandleOrderedList(content)
        case 'unordered-list':
            return mdHandleUnorderedList(content)
        default:
            return content
    }
}

/**
 * Parses given string into a Markdown Ordered List.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '1. Hello World'
 */
const mdHandleOrderedList = (text: string): string => {
    const lines = text.split(/\r\n|\r|\n/)

    if (lines.length === 1) return `1. ${text}`

    for (let i = 0; i < lines.length; i++) {
        lines[i] = `${i + 1}. ${lines[i]}`
    }

    return lines.join('\r\n')
}

/**
 * Parses given string into a Markdown Unordered List.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '- Hello World'
 */
const mdHandleUnorderedList = (text: string): string => {
    const lines = text.split(/\r\n|\r|\n/)

    if (lines.length === 1) return `- ${text}`

    for (let i = 0; i < lines.length; i++) {
        lines[i] = `- ${lines[i]}`
    }

    return lines.join('\r\n')
}

/**
 * Parses given string into a Markdown Code Block.
 * @param text The text to parse.
 * @param lang The language of the code block.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '\`\`\`\r\nHello World\r\n\`\`\``
 */
const mdHandleCodeBlock = (text: string, lang?: string): string => {
    return `\`\`\`${lang ?? ''}\r\n${text}\r\n\`\`\``
}

/**
 * Parses given string into a Markdown Quote.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '> Hello World'
 */
const mdHandleQuote = (text: string): string => {
    const lines = text.split(/\r\n|\r|\n/)

    if (lines.length === 1) return `> ${text}`

    for (let i = 0; i < lines.length; i++) {
        lines[i] = `> ${lines[i]}`
    }

    return lines.join('\r\n')
}

/**
 * Parses given string into a Markdown Bold.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '**Hello World**'
 */
const mdHandleBold = (text: string): string => {
    return `**${text}**`
}

/**
 * Parses given string into a Markdown Italic.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '*Hello World*'
 */
const mdHandleItalic = (text: string): string => {
    return `*${text}*`
}

/**
 * Parses given string into a Markdown Code.
 * @param text The text to parse.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '`Hello World`'
 */
const mdHandleCode = (text: string): string => {
    return `\`${text}\``
}

/**
 * Parses given string into a Markdown Link.
 * @param text The text to parse.
 * @param url The url to link to.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '[Hello World](example.com)'
 */
const mdHandleLink = (text: string, url = 'example.com'): string => {
    return `[${text}](${url})`
}

/**
 * Parses given string into a Markdown Heading.
 * @param text The text to parse.
 * @param level The level of the heading.
 * @returns The parsed Markdown string.
 * @example 'Hello World' // returns '# Hello World'
 */
const mdHandleHeading = (text: string, level = 1): string => {
    return `${'#'.repeat(level)} ${text}`
}
