class Rating {
    constructor(nameSelector = '', options = {}, type = 'selector') {
        this.nameSelect = nameSelector;
        this.options = options;
        switch (type) {
            case "selector":
                this.getStarWithSelector(options.name, options.rowClass);
                this.runSelector();
                break;
            case "displays" :
                this.runDisplays();
                break;
            case "display" :
                this.runDisplay();
                break;
            case "filter":
                this.getStarWithSelector(options.name, options.rowClass);
                this.runFilter();
                break;
        }
    }
    getStarWithSelector(name = 'rating', rowClass = '')
    {
        let html,
            options;
        options = this.options;
        html = '<select name="' + name + '" class="input xs-selector ' + rowClass + '" style="display: none">';
        html += '<option value=""></option>';
        $.each(options.value, (key, value) => {
            html += '<option value="' + key + '">' + value + '</option>';
        });
        html += '</select>';
        html += '<div class="xs-widget">';
        $.each(options.value, (key, value) => {
            html += '<a href="#" data-rating-value="' + key + '" data-rating-text="' + value + '"></a>';
        });
        html += '</div>';
        html += '<div class="xs-rating-text"></div>';
        $(this.nameSelect).html(html);
    }
    runSelector()
    {
        var row = this;
        $(row.nameSelect + ' .xs-widget a')
            .click(function () {
                let parent = $(this).closest(row.nameSelect);
                let currentStar = $(this).data('rating-value');
                parent.find('.xs-selector').val(currentStar);
                return false;
            })
            .mouseenter(function() {
                let currentStar = $(this).data('rating-value');
                let parent = $(this).closest(row.nameSelect);
                parent.find('.xs-rating-text').html($(this).data('rating-text'));
                for (let i = 1; i <= currentStar; ++i)
                {
                    let ratingClass = parent.find('[data-rating-value=' + i + ']');
                    ratingClass.addClass('xs-start-is-active');
                }
                let starLength = row.ObjectLength(row.options.value);
                for (let i = starLength; i > currentStar; --i)
                {
                    parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                }
            })
        $(row.nameSelect + ' .xs-widget')
            .mouseenter(() => {
                let parent = $(this).closest(row.nameSelect);
                parent.find('.xs-start-is-current').removeClass('xs-start-is-current');
            })
            .mouseleave(function() {
                let parent = $(this).closest(row.nameSelect);
                let valStar =  parent.find('.xs-selector').val();
                let starLength = row.ObjectLength(row.options.value);

                if(valStar === '')
                {
                    for (let i = starLength; i >= 1; --i)
                    {
                        parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                    }
                    parent.find('.xs-rating-text').html('')
                }
                else
                {
                    let clickStar = parent.find('[data-rating-value=' + valStar + ']');
                    clickStar.addClass('xs-start-is-current');
                    parent.find('.xs-rating-text').html(clickStar.data('rating-text'))
                    for (let i = starLength; i >= 1; --i)
                    {
                        if(parseInt(valStar) < i)
                        {
                            parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                        }
                        else
                        {
                            parent.find('[data-rating-value=' + i + ']').addClass('xs-start-is-active');
                        }
                    }
                }

            });
    }
    display(star)
    {
        let options,
            html;
        options = this.options;
        html = '<span class="xs-rating-stars xs-rating-stars--smaller" title="' + star + '">'
        for (let i = 1; i <= options.numberStar; ++i)
        {
            if(star >= i)
            {
                html += '<span class="xs-rating-star xs-rating-star--full"></span>';
            }
            else if(star >= (i - 0.50))
            {
                html += '<span class="xs-rating-star xs-rating-star--half"></span>';
            }
            else
            {
                html += '<span class="xs-rating-star"></span>';
            }
        }
        return html + '</span>'
    }
    runDisplays() {
        let row = this;
        $.each($(this.nameSelect), function () {
            $(this).html(row.display($(this).data(row.options.dataName)))
        })
    }
    runDisplay() {
        let query = $(this.nameSelect);
        query.html(this.display(query.data(this.options.dataName)))
    }
    runFilter()
    {
        var row = this;
        $(row.nameSelect + ' .xs-widget a')
            .click(function () {
                let parent = $(this).closest(row.nameSelect);
                let currentStar = $(this).data('rating-value');
                parent.find('.xs-selector').val(currentStar);
                return false;
            })
            .mouseenter(function() {
                let currentStar = $(this).data('rating-value');
                let parent = $(this).closest(row.nameSelect);
                let starLength = row.ObjectLength(row.options.value);
                parent.find('.xs-rating-text').html($(this).data('rating-text'));
                for (let i = starLength; i >= currentStar; --i)
                {
                    let ratingClass = parent.find('[data-rating-value=' + i + ']');
                    ratingClass.addClass('xs-start-is-active');
                }
                for (let i = 1; i < currentStar; ++i)
                {
                    parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                }
            })
        $(row.nameSelect + ' .xs-widget')
            .mouseenter(() => {
                let parent = $(this).closest(row.nameSelect);
                parent.find('.xs-start-is-current').removeClass('xs-start-is-current');
            })
            .mouseleave(function() {
                let parent = $(this).closest(row.nameSelect);
                let valStar =  parent.find('.xs-selector').val();
                let starLength = row.ObjectLength(row.options.value);

                if(valStar === '')
                {
                    for (let i = starLength; i >= 1; --i)
                    {
                        parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                    }
                    parent.find('.xs-rating-text').html('')
                }
                else
                {
                    let clickStar = parent.find('[data-rating-value=' + valStar + ']');
                    clickStar.addClass('xs-start-is-current');
                    parent.find('.xs-rating-text').html(clickStar.data('rating-text'));
                    for (let i = starLength; i >= 1; --i)
                    {
                        if(parseInt(valStar) > i)
                        {
                            parent.find('[data-rating-value=' + i + ']').removeClass('xs-start-is-active');
                        }
                        else
                        {
                            parent.find('[data-rating-value=' + i + ']').addClass('xs-start-is-active');
                        }
                    }
                }

            });
        let options = this.options;
        let currentClass = $('.' + options.nameClass);
        let val = currentClass.data(options.dataName);
        if(val > 0.00)
        {
            currentClass.find('.xs-selector').val(val);
            let starLength = row.ObjectLength(row.options.value);
            for(let i = starLength; i >= val; --i)
            {
                console.log(currentClass);
                console.log(currentClass.find('.xs-widget a')[i - 1]);
                $(currentClass.find('.xs-widget a')[i - 1]).addClass('xs-start-is-active');
            }
            let text = $(currentClass.find('.xs-widget a')[val - 1]).data('rating-text');
            currentClass.find('.xs-rating-text').html(text);
            currentClass.find('.xs-rating-text').addClass('xs-start-is-current')
        }

    }
    ObjectLength(object) {
        var length = 0;
        for( let key in object ) {
            if( object.hasOwnProperty(key) ) {
                ++length;
            }
        }
        return length;
    };
}