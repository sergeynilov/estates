export function formatValue(value, rateDecimalNumbers) {
    if (isEmpty( value ) ) return ''
    if ( typeof value === 'string' ) {
        value = parseFloat(value)
    }
    return value.toFixed(rateDecimalNumbers)
}

export function isEmpty(value) {
    if (typeof value === 'object') {
        if (value === null) return true
        if (value.length === 0) return true
    }
    if (value === undefined) return true
    if (value === null) return true
    if (value === '') return true
}


export function pluralize(itemsLength, singleLabel, pluralLabel) {
    return itemsLength > 1 ? pluralLabel : singleLabel
}
