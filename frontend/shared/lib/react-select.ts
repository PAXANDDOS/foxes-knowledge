import type { StylesConfig } from 'react-select'
import color from './color'

export const tagStyles: StylesConfig = {
    control: styles => ({
        ...styles,
        background: 'transparent',
        border: 'none',
    }),
    option: (styles, { isDisabled }) => ({
        ...styles,
        cursor: isDisabled ? 'not-allowed' : 'pointer',
    }),
    multiValue: (styles, { data }) => ({
        ...styles,
        backgroundColor: (data as Tag).color,
    }),
    multiValueLabel: (styles, { data }) => ({
        ...styles,
        color: color((data as Tag).color, {
            black: '#3a3a3a',
            white: '#fafafa',
            threshold: 0.28439059,
        }),
    }),
    multiValueRemove: (styles, { data }) => ({
        ...styles,
        color: color((data as Tag).color, {
            black: '#3a3a3a',
            white: '#fafafa',
            threshold: 0.28439059,
        }),
        cursor: 'pointer',
        ':hover': { color: '#e4e4e4' },
    }),
}
