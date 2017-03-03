function formatCurrency(elem) {

    var num = elem.value;

    // Remove any characters other than numbers and periods from the string, then parse the number
    var nNumberToFormat = parseFloat( String(num).replace(/[^0-9\.]/g, '') );
    // Escape when this number is invalid (parseFloat returns NaN on failure, we can detect this with isNaN)
    if( isNaN(nNumberToFormat) ) { nNumberToFormat = 0; }

    // Split number string by decimal separator (.)
    var aNumberParts = nNumberToFormat.toFixed(2).split('.');

    // Get first part = integer part
    var sFirstPart = aNumberParts[0];
    // Determine the position after which to start grouping
    var nGroupingStart = sFirstPart.length % 3;
    // Shift three to the right when first group is empty
    nGroupingStart += (nGroupingStart == 0) ? 3 : 0;
    // Start first result with ungrouped first part
    var sFirstResult = sFirstPart.substr(0, nGroupingStart);
    // Add grouped parts by looping through the remaining numbers
    for(var i=nGroupingStart, len=sFirstPart.length; i < len; i += 3) {
        sFirstResult += ',' + sFirstPart.substr(i, 3);
    }

    // Get second part = fractional part
    var sSecondResult = aNumberParts[1] ? '.' + aNumberParts[1] : '';

    // Combine the parts and return the result
    s = sFirstResult + sSecondResult;

    elem.value = s;


}