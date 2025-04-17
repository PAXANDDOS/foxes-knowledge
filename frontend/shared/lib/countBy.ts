/**
 * Function to count the number of objects in array with specific key value.
 * @param array Array to count by.
 * @param key Property to check.
 * @param value Expected value.
 * @returns Number of successful matches.
 */
export const countBy = (array: { [x: string]: any }[], key: string, value: string) =>
    array.filter(obj => obj[key] === value).length
