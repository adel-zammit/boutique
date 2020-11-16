class editor {
    constructor(button = []) {
        this.instanceButton =  new EditorButton(button);
        this.buttonList = button;
        this.button = this.instanceButton.buttonList();
        this.className = 'editor';
    }
    run()
    {
        this.format("defaultParagraphSeparator", "p");
        $('.' + this.className + ' textarea').css('display', 'none');
        this.getInfo();
    }
    getInfo()
    {
        this.OnSet();
        this.Onclick();
        this.OnSubmit();
        this.OnFocus();
        this.OnBlur();
    }
    format(command, value) {
        document.execCommand(command, false, value);
    }
    replaceAll(recherche, replace, message)
    {
        var chaine = message;
        var re = new RegExp(recherche, 'g');
        return chaine.replace(re, replace);
    }
    OnSet()
    {
        this.setButton()
    }
    setClassName(className)
    {
        this.className = className;
    }
    Onclick()
    {
        var classTigger = this;
        var click = [
            '.placeholder-editor' ,
            '.js-popup-editor-button',
            'body',
            '.button-editor-content',
            '.button-insert-content',
            '.fr-select-color'
        ];
        click.forEach(function(item) {
            $(item).click(function(e) {
                switch(item){
                    case '.placeholder-editor' :
                        classTigger.clickPlaceholder(e, $(this));
                        break;
                    case '.js-popup-editor-button' :
                        if($(this).closest('.base-style-editor').hasClass(classTigger.className)) {
                            classTigger.clickEditorButton(e, $(this));
                        }
                        break;
                    case 'body' :
                        classTigger.clickBody(e, $(this));
                        break;
                    case '.button-editor-content' :
                        if($(this).closest('.base-style-editor').hasClass(classTigger.className))
                        {
                            classTigger.clickButtonContent(e, $(this));
                        }
                        break;
                    case '.button-insert-content' :
                        if($(this).closest('.base-style-editor').hasClass(classTigger.className)) {
                            classTigger.clickButtonInsertContent(e, $(this));
                        }
                        break;
                    case '.fr-select-color' :
                        if($(this).closest('.base-style-editor').hasClass(classTigger.className)) {
                            classTigger.clickColor(e, $(this));
                        }
                        break;
                }
            })
        });
    }
    OnSubmit()
    {
        var classTigger = this;
        var Submit = [
            '.form-submit-action'
        ];
        Submit.forEach(function(item) {
            $(item).submit(function() {
                classTigger.submitAction($(this));
            })
        });
    }
    OnFocus()
    {
        var classTigger = this;
        var focus = [
            '.editor-write'
        ];
        focus.forEach(function(item) {
            $(item).focus(function() {
                classTigger.focusWrite($(this));
            })
        });
    }
    OnBlur()
    {
        var classTigger = this;
        var blur = [
            '.editor-write'
        ];
        blur.forEach(function(item) {
            $(item).blur(function() {
                classTigger.blurWrite($(this));
            })
        });
    }
    blurWrite(ClassItem)
    {
        var parent = ClassItem.closest('.' + this.className);
        parent.removeClass('is-focus');
    }
    focusWrite(ClassItem)
    {
        var parent = ClassItem.closest('.' + this.className);
        parent.addClass('is-focus');
    }
    setButton()
    {
        var instanceButton = new EditorButton(this.buttonList);

        $('.' + this.className + ' .button-editor').append(instanceButton.renderButton());
    }
    clickPlaceholder(e, ClassItem)
    {
        var parent = ClassItem.closest('.profile-post');
        ClassItem.addClass('is-hidden');
        parent.find('.list-button').removeClass('is-hidden');
        parent.find('.' + this.className).removeClass('is-hidden');
        parent.find('.editor-write').focus();
    }
    clickEditorButton(e, ClassItem)
    {
        var classCss,
            parent,
            otherClass,
            classClose,
            popupClose;
        classCss = ClassItem.find('.button-list-popup');
        parent = ClassItem.closest('.form-submit-action');
        otherClass = parent.find('.button-editor');

        popupClose = otherClass.find('.js-popup-editor-button');

        if(!$(e.target).is(parent) && !$.contains(parent.get(0),e.target))
        {
            popupClose.removeClass('popup-open-editor');
            classClose = popupClose.find('.button-list-popup');
            classClose.animate({opacity:0}, 100).queue(function (next) {
                $(this).css('display', 'none');
                next();
            });
        }
        else if(ClassItem.hasClass('popup-open-editor'))
        {
            if(ClassItem.find('.input-editor').length > 0)
            {
                var div = ClassItem.find('.input-editor');
                if(!$(e.target).is(div) && !$.contains(div[0],e.target))
                {
                    ClassItem.removeClass('popup-open-editor');
                    classCss.animate({opacity:0}, 100).queue(function (next) {
                        $(this).css('display', 'none');
                        next();
                    });
                }
            }
            else
            {

                ClassItem.removeClass('popup-open-editor');
                classCss.animate({opacity:0}, 100).queue(function (next) {
                    $(this).css('display', 'none');
                    next();
                });
            }

        }
        else if(!ClassItem.hasClass('popup-open-editor'))
        {
            classCss.css('opacity', 0);
            ClassItem.addClass('popup-open-editor');
            classCss.css('display', 'block').animate({opacity:1}, 100 );
        }
    }
    clickBody(e, ClassItem)
    {
        var other,
            div,
            parent,
            dataButton,
            length;
        other = ClassItem.find('.button-editor');
        div =  other.find('.js-popup-editor-button');
        parent = $(e.target).parents(".button-editor-content");
        dataButton = parent.data('type-button-kick');
        length = $(e.target).parents(".button-type-" + dataButton).length;

        if(dataButton === undefined)
        {
            parent = $(e.target);
            dataButton = parent.data('type-button-kick');
            if(parent.hasClass('button-type-' + dataButton))
            {
                length = 1;
            }
        }
        if(length === 0)
        {
            div.removeClass('popup-open-editor');
            var classCss = div.find('.button-list-popup');
            classCss.animate({opacity:0}, 100).queue(function (next) {
                $(this).css('display', 'none');
                next();
            });
        }
        $.each($('.js-popup-editor-button'), function () {
            if(!$(this).hasClass('button-type-' + dataButton) )
            {
                $(this).removeClass('popup-open-editor');
                var classCss = $(this).find('.button-list-popup');
                classCss.animate({opacity:0}, 100).queue(function (next) {
                    $(this).css('display', 'none');
                    next();
                });
            }
        })
    }
    clickButtonContent(e, ClassItem)
    {
        var typeButton = ClassItem.data('type-button');

        var valueButton = this.button[typeButton];
        var value;
        if(valueButton !== undefined)
        {

            if(valueButton.paramsList.length > 0)
            {
                value = ClassItem.data('param1');
                if(value !== undefined)
                {
                    this.format(typeButton, value);
                    var fontElements = document.getElementsByTagName("font");

                    for (var i = 0, len = fontElements.length; i < len; ++i) {
                        if (fontElements[i].size === "7") {
                            fontElements[i].removeAttribute("size");
                            fontElements[i].style.fontSize = value + 'px';
                        }
                    }
                }
            }
            else if(valueButton.past)
            {
                value = ClassItem.data('param1');
                if(value !== undefined)
                {
                    this.format(value)
                }
            }
            else if(!valueButton.writeB)
            {
                this.format(typeButton)
            }
            else
            {
                if(valueButton.params)
                {
                    this.format('insertText', '[' + valueButton.BBCode + '=]' + '[/' + valueButton.BBCode + ']')
                }
                else
                {
                    this.format('insertText', '[' + valueButton.BBCode + ']' + '[/' + valueButton.BBCode + ']')
                }
            }
        }
    }
    clickButtonInsertContent(e,ClassItem)
    {
        var typeButton = ClassItem.data('type-button');

        var valueButton = this.button[typeButton];console.log(valueButton)
        var parent,
            valueCss;
        parent = ClassItem.closest('.js-popup-editor-button');
        valueCss = [];
        console.log(this.button)
        $.each(valueButton.input, function (key, value) {
            valueCss[key] = parent.find('.input-class-' + key).val();
        })
        if(typeButton === 'linkInsert')
        {
            var parentBig,
                html;
            parentBig = ClassItem.closest('.' + this.className);
            parentBig.find('.editor-write').focus();
            html = "<a href='" + valueCss['url'] + "' class='link-insert'>" + valueCss['text'] + "</a>"
            this.format('insertHTML', html)
        }
        else if(typeButton === 'foreColor')
        {
            this.format(typeButton, valueCss['text'])
        }
    }
    clickColor(e, ClassItem)
    {
        var typeButton = ClassItem.data('type-button');
        var button = this.button;
        var valueButton = button[typeButton];
        var parent,
            value,
            parentBig;
        parent = ClassItem.closest('.js-popup-editor-button');
        value = ClassItem.data('param1');
        parentBig = ClassItem.closest('.editor');
        parentBig.find('.editor-write').focus();
        if(value === 'REMOVE')
        {
            this.format('removeFormat')
        }
        else{
            this.format(typeButton, value)
        }
    }
    submitAction(ClassItem)
    {
        var classCurrent = this;
        $.each($('.base-style-editor'), function () {
            var message,
                parent,
                valueParams;
            message = $(this).find('.editor-write').html();
            message = classCurrent.replaceAll('<(div)(.*?)<(/div)>', '<p $2 </p>', message);
            message = classCurrent.replaceAll('<br>', '\n', message);
            message = classCurrent.replaceAll('<(span)(.style=\"(.*?)\")>', '', message);
            message = classCurrent.replaceAll('<(br)(.style=\"(.*?)\")>', '\n', message);
            message = classCurrent.replaceAll('<(/span)>', '', message);
            parent = ClassItem.data('params');
            console.log(message);
            if(parent !== undefined)
            {
                valueParams = $(this).find('input[name=' + parent  + ']').val();
                $(this).find("#editor-" + valueParams).val(message);
            }
            else
            {
                $(this).find("#editor").val(message);
            }
        });
    }
}