/**
 *  Standart WPM value for reading time
 */
const wpm = 265

/**
 *  Calculates the reading time of a text
 *  @param {string} text The text to calculate the reading time for
 *  @returns {number} The reading time in minutes
 *  @example
 *  readingTime('Hello World') // 1
 */
export const getTextReadingTime = (text: string): number => {
    const words = text.trim().split(/\s+/).length
    return Math.ceil(words / wpm)
}
