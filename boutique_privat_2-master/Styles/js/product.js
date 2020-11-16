function priceFormat(price)
{
    let arrayPrice = price.toString().split('.');
    return  arrayPrice[0] + '€' + (arrayPrice.length === 2 ? '<sup>' + arrayPrice[1].padEnd(2,'0') + '</sup>' : '<sup>00</sup>');
}