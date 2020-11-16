
var min = $('.rule-slider .min');
var max = $('.rule-slider .max');
var maxWidth = max.position().left;
var mibWidth = min.position().left;
var gap =  max.data('value') - min.data('value');
var offsetLeftMax = maxWidth;
var offsetLeftMin = mibWidth;
let showCatParent = $('[data-show-category=1]').closest('.master-category');
showCatParent.addClass('is-active-parent');
showCatParent.find('.categoryList-toggler').addClass('is-active');
showCatParent.find('.categoryList').stop(true,true).slideDown();

$(document).ready(() => {
    $('.delete-filter')
        .mouseenter(function () {
            $(this).find('.delete-filter-content').html("&nbsp;&nbsp;" + $(this).data('delete-message'));
            $(this).stop(true).animate({ width: "130px",}, {easing: false});
            $(this).find('.delete-filter-logo').stop(true).animate(
                { deg: 360 },
                {
                    duration : 2500,
                    easing: 'easeOutElastic',
                    step: function(now) {
                        $(this).css({ transform: 'rotate(' + now + 'deg)' });
                    }
                }
            );
        })
        .mouseleave(function() {
            $(this).stop(true).animate({ width: "20px"});
            $(this).find('.delete-filter-logo').stop(true).animate(
                { deg: 0 },
                {
                    duration : 2500,
                    easing: 'easeOutElastic',
                    step: function(now) {
                        $(this).css({ transform: 'rotate(' + now + 'deg)' });
                    }
                },
            );
        })
        .click(function () {
            let prop = window.location.pathname;
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            let dataParams = $(this).data('filter-delete');
            dataParams.split(',').forEach(value => {
                console.log(value);
                urlParams.delete(value);
            });
            let urlToString = urlParams.toString();
            let getUrl = getUrlBase();
            if(urlToString !== '')
            {
                if(prop.match(/index\.php/))
                {
                    getUrl += '&' + urlParams.toString();
                }
                else
                {
                    getUrl += '?' + urlParams.toString();
                }
            }
            window.location.replace(getUrl);
        });
    $('[data-toggle=tooltip]')
        .mouseover(function () {
            let offset = $(this).offset();
            if($('.tooltip-start').length)
            {
                $('.tooltip-start .tooltip-content').html($(this).data('tooltip-title'));
                let percentage = ($('.tooltip-start').width() * (50 / 100)) - 5;
                let left = offset.left - percentage;
                $('.tooltip-start').css('display', 'block');
                $('.tooltip-start').stop(true).css('top',  offset.top - ($('.tooltip-start').height() + 5)).css('left', left).animate({opacity:1},
                    {duration: 100});
            }
            else
            {
                let html = '<div class="tooltip-start">';
                html += '<div class="tooltip-arrow"></div>';
                html += '<div class="tooltip-content">';
                html += $(this).data('tooltip-title');
                html += '</div>';
                html += '</div>';
                $('body').append(html);
                $('.tooltip-start').css('opacity', 0);
                let percentage = $('.tooltip-start').width()  * (50 / 100)- 5;
                let left = offset.left - percentage;
                $('.tooltip-start').stop(true).css('top',  offset.top - ($('.tooltip-start').height() + 5)).css('left', left).css('display', 'block').animate({opacity:1},
                    {duration: 100});
            }
        })
        .mouseout(function() {
            $('.tooltip-start').stop(true).animate({opacity:0}, {duration: 50}).queue(function (next) {
                $(this).css('display', 'none');
                next();
            });
        });
    new Rating('.xs-displays', {
            numberStar : 5,
            rowClass : '',
            dataName : 'rating'
        },
        'displays'
    );
    new Rating('.xs-select', {
            value : {
                1 : 'Pas terrible',
                2 : 'Pas top',
                3 : 'Moyenne',
                4 : 'Bien',
                5 : 'Excellent',
            },
            name : 'rating',
            rowClass : '',
            dataName : 'filter-rating',
            nameClass : 'xs-widget-filters'
        },
        'filter'
    );
    $('.handle')
        .draggable({
            axis: "x",
            drag: function (e, ui){
                var leftPosition = ui.position.left;
                let positiveMin =  -1 * mibWidth;
                if($(this).hasClass('max'))
                {
                    if (leftPosition < 0) {
                        ui.position.left = 0;
                    }
                    if (leftPosition > maxWidth) {
                        ui.position.left = maxWidth;
                    }
                    if(leftPosition <  offsetLeftMin + positiveMin)
                    {
                        ui.position.left = parseFloat(offsetLeftMin) + positiveMin;
                    }

                    leftPosition = ui.position.left;
                    offsetLeftMax = leftPosition;
                    let percentage = 100 * ((maxWidth - leftPosition) / maxWidth);
                    getMaxMin(parseFloat($(this).data('value')), parseFloat($(this).data('value-min')), 'input-max', percentage)
                }
                else
                {
                    if (leftPosition > maxWidth - positiveMin) {
                        ui.position.left = maxWidth - positiveMin;
                    }
                    if (leftPosition < mibWidth) {
                        ui.position.left = -13;
                    }
                    if(leftPosition >  offsetLeftMax - positiveMin)
                    {
                        ui.position.left = offsetLeftMax - positiveMin;
                    }
                    leftPosition = ui.position.left;
                    offsetLeftMin = leftPosition;
                    percentage = 100 * (((maxWidth) - (leftPosition + positiveMin)) / (maxWidth));
                    getMaxMin(parseFloat($(this).data('value-max')), parseFloat($(this).data('value')), 'input-min', percentage)
                }
            },
        });

    $('[data-show=1]').find('.categoryList').stop(true,true).slideDown();
    $('.categoryList-toggler').click(function () {
        var parent = $(this).closest('.categoryList-item');
        if(parent.hasClass('is-active-parent'))
        {
            $(this).removeClass('is-active');
            parent.removeClass('is-active-parent');
            parent.find('.categoryList').stop(true,true).slideUp();
        }
        else
        {
            $(this).addClass('is-active');
            parent.addClass('is-active-parent');
            parent.find('.categoryList').stop(true,true).slideDown();
        }

    });
    $(location).attr('search').replace('?', '').split('&').forEach(function (value) {
        let valueArray = value.split('=');
        if(valueArray[0] !== '')
        {
            let cookieDecodeMax = getCookie('max_price');
            let cookieDecodeMin = getCookie('min_price');
            if(valueArray[0] === 'min_price')
            {
                $('.handle.min').css('left', cookieDecodeMin + 'px');
                $('.input-min').val(valueArray[1]);
                offsetLeftMin = parseFloat(cookieDecodeMin);
            }
            else if(valueArray[0] === 'max_price')
            {
                $('.handle.max').css('left', cookieDecodeMax + 'px');
                $('.input-max').val(valueArray[1]);
                offsetLeftMax = parseFloat(cookieDecodeMax);
            }
        }

    });
    $('.button-save-filter').click(function () {
        let parent = $(this).closest('.block-content-sidebar');
        let prop = window.location.pathname;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        let getUrl = "";
        if($(this).hasClass('type-price'))
        {
            let valOutput = [];
            $.each(parent.find('.input-filter-style'), function (key) {
                valOutput[key] = $(this).attr('name') + '=' + $(this).val();
            });

            var joinVal = valOutput.join('&');

            if(prop.match(/index\.php/))
            {
                getUrl = getUrlBase();
                getUrl += '&' + joinVal;
            }
            else
            {
                getUrl = getUrlBase();
                getUrl += '?' + joinVal;
            }
            if(urlParams.get('rating'))
            {
                getUrl += '&rating=' + urlParams.get('rating');
            }
            document.cookie = "max_price=" + parent.find('.handle.max').position().left;
            document.cookie = "min_price=" + parent.find('.handle.min').position().left;
        }
        else
        {
            let val = $('.xs-selector').val();
            if(prop.match(/index\.php/))
            {
                getUrl = getUrlBase();
                getUrl += '&rating=' + val;
            }
            else
            {
                getUrl = getUrlBase();
                getUrl += '?rating=' + val;
            }
            if(urlParams.get('min_price') || urlParams.get('max_price'))
            {
                getUrl += '&min_price=' + urlParams.get('min_price') + '&max_price=' + urlParams.get('max_price');
            }
        }
        window.location.replace(getUrl);
    });
    $('.event-click-slider').click(function (e) {
        let parent = $(this).closest('.filter-price');
        let offset = this.getClientRects()[0];
        let leftPosition = e.clientX - offset.left;
        let maxHandleWidth = $(this).closest('.rule-slider').find('.handle.max').position().left;
        let minHandleWidth = $(this).closest('.rule-slider').find('.handle.min').position().left;
        let gap = (maxHandleWidth - minHandleWidth);
        let positiveMin =  -1 * mibWidth;
        let f  = leftPosition - minHandleWidth;
        if(f > (gap / 2))
        {
            parent.find('.handle.max').css('left', leftPosition + 'px');
            if (leftPosition > maxWidth) {
                parent.find('.handle.max').css('left', maxWidth + 'px');
            }
            let percentage = ( 100 * ((maxWidth - leftPosition) / maxWidth));
            offsetLeftMax = leftPosition;
            let valuePrice = getMaxMin(parseFloat(parent.find('.handle.max').data('value')), parseFloat(parent.find('.handle.max').data('value-min')), 'input-max', percentage );
            if(valuePrice > parseFloat(parent.find('.handle.max').data('value')))
            {
                $('.input-max').val(parent.find('.handle.max').data('value'));
            }
        }
        else
        {
            parent.find('.handle.min').css('left', leftPosition + 'px');
            let percentage = 100 * (((maxWidth) - (leftPosition + positiveMin)) / (maxWidth));
            offsetLeftMin = leftPosition;

            getMaxMin(parseFloat(parent.find('.handle.min').data('value-max')), parseFloat(parent.find('.handle.min').data('value')), 'input-min', percentage);
        }
    });
});

function getCookie(cname) {
    let name = cname + "=";
    let ca = document.cookie.split(';');
    for(let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function getUrlBase()
{
    if(window.location.protocol !== "https:")
    {
        return 'http://' + $(location).attr('hostname') + window.location.pathname;
    }
    else
    {
        return 'https://' + $(location).attr('hostname') + window.location.pathname;
    }
}

function getMaxMin(value, valueMin, Input, percentage)
{
    let price = value;
    let dif = price - valueMin;
    price = (dif * ( 1 - (percentage/100))) + valueMin;
    $('.' + Input).val(price.toFixed(2));
    return price.toFixed(2);
}
