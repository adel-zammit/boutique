class  EditorButton {
    constructor(button = []) {
        var buttonList = this.getButtonList();
        if(button.length === 0)
        {
            this.buttons = buttonList;
        }
        else
        {
            let output = {};
            let currentClass = this;

            button.forEach(function (value, key) {
                let currentButton = currentClass.getButtonList()[value];
                output[value] = currentButton;

           });console.log(output);
            this.buttons = output;
        }
    }
    getButtonList()
    {
        return  {
            'bold' : {
                'fa' :'far fa-bold',
                'BBCode' : 'B',
                'writeB' : false,
                'params' : false,
                'paramsList' : []
            },
            'italic' : {
                'fa' : 'far fa-italic',
                'BBCode' : 'I',
                'writeB' : false,
                'params' : false,
                'paramsList' : []
            },
            'underline' : {
                'fa' : 'far fa-underline',
                'BBCode' : 'I',
                'writeB' : false,
                'params' : false,
                'paramsList' : []
            },
            'fa' : {
                'fa' : 'far fa-flag',
                'BBCode' : 'FA',
                'writeB' : true,
                'params' : false,
                'paramsList' : []
            },
            'linkInsert' : {
                'fa' : 'far fa-link',
                'BBCode' : 'URL',
                'writeB' : true,
                'params' : true,
                'paramsList' : [],
                'input' : {
                    'url' : {
                        'type' : 'text',
                        'placeholder' : 'URL',
                        'name' : 'href',
                    },
                    'text' : {
                        'type' : 'text',
                        'placeholder' : 'Text',
                        'name' : 'text'
                    }
                }
            },
            'fontSize' : {
                'fa' : 'far fa-text-height',
                'BBCode' : 'SIZE',
                'writeB' : true,
                'params' : true,
                'paramsList' : [9, 10, 12, 15, 18, 22, 26]

            },
            'foreColor' : {
                'fa' : 'far fa-tint',
                'BBCode' : 'COLOR',
                'writeB' : true,
                'params' : true,
                'paramsList' : {},
                'color' : ['#2C82C9', '#54ACD2'],
                'input' : {
                    'text' : {
                        'type' : 'text',
                        'placeholder' : 'HEX Color',
                        'name' : 'color'
                    }
                }
            },
            'fontAlign' : {
                'fa' : 'far fa-align-left',
                'BBCode' : 'SIZE',
                'writeB' : true,
                'params' : true,
                'past' : true,
                'paramsList' : {
                    'justifyLeft' : {
                        'value' : 'justifyLeft',
                        'fa' : 'far fa-align-left'
                    },
                    'justifyCenter' : {
                        'value' : 'justifyCenter',
                        'fa' : 'far fa-align-center'
                    },
                    'justifyRight' : {
                        'value' : 'justifyRight',
                        'fa' : 'far fa-align-right'
                    },
                }
            },
        };
    }
    renderHtml()
    {
        var line = "";
        $.each(this.buttons, function (key, value) {
            var paramsListJSON = JSON.stringify(value.paramsList),
                AddClass,
                typeButton,
                outputButton;
            paramsListJSON = JSON.stringify(value.paramsList);
            AddClass = value.paramsList.length > 0 || value.input !== undefined || Object.keys(paramsListJSON).length > 2 ? 'js-popup-editor-button' : '';
            typeButton = value.paramsList.length > 0 || value.input !== undefined  || Object.keys(paramsListJSON).length > 2 ? '' : "data-type-button=\"" + key + "\"";
            line += "<button type=\"button\" class=\"button-editor-content " + AddClass + " button-type-" + key + "\" " + typeButton + " role=\"button\" data-type-button-kick=\""  + key + "\"><i class=\"" + value.fa +"\" aria-hidden=\"true\"></i>";

            if(value.paramsList.length > 0 || Object.keys(paramsListJSON).length > 2)
            {
                outputButton = "";
                $.each(value.paramsList, function (keyParams, valueParams) {
                    outputButton += "<li role=\"presentation\">";
                    if(valueParams.fa)
                    {
                        outputButton += "<a class=\"js-popup-editor button-editor-content \" tabindex=\"-1\" role=\"option\" data-type-button=\"" + key + "\" data-param1=\"" + valueParams.value + "\" title=\"" + valueParams.value + "\" aria-selected=\"false\"><i class='" + valueParams.fa + "'></i></a>";
                    }
                    else
                    {
                        outputButton += "<a class=\"js-popup-editor button-editor-content \" tabindex=\"-1\" role=\"option\" data-type-button=\"" + key + "\" data-param1=\"" + valueParams + "\" title=\"" + valueParams + "\" aria-selected=\"false\">" + valueParams + "</a>";
                    }
                    outputButton += "</li>";
                });
                line += "<div class=\"button-list-popup button-list-" + key + " \">" +
                    "<ul class=\"fr-dropdown-list\" role=\"presentation\">" +
                    outputButton
                    + "</div>";
            }
            else if(value.input !== undefined)
            {
                outputButton = "";

                $.each(value.input, function (keyParams, valueParams) {
                    outputButton += "<div class=\"fr-input-line\">";
                    outputButton += "<input class='input-editor input-class-" + keyParams +"' type='" + valueParams.type + "' name='" + valueParams.name + "' placeholder='" + valueParams.placeholder + "'>";
                    outputButton += "</div>";
                });
                outputButton += "<div class=\"button fr-submit button-insert-content\" role=\"button\" data-type-button=\"" + key + "\" tabindex=\"3\">Insert</div>";
                if(value.color !== undefined)
                {
                    var color;
                    color = "<div class=\"fr-popup fr-desktop\" >";
                    $.each(value.color, function (keyColor, valueColor) {

                        color += "<span class=\"fr-select-color\" style=\"background: " + valueColor + ";\" tabindex=\"-1\" aria-selected=\"false\" role=\"button\" data-type-button=\"" + key + "\" data-param1=\"" + valueColor + "\"><span class=\"fr-sr-only\">Color " + valueColor + "</span></span>"
                    })
                    color += "<span class=\"fr-select-color\" data-type-button=\"" + key + "\" tabindex=\"-1\" role=\"button\" data-param1=\"REMOVE\" title=\"Remove formatting\"><i class=\"far fa-eraser\" aria-hidden=\"true\"></i><span class=\"fr-sr-only\">Remove formatting</span></span>";
                    color += "</div><div class=\"fr-color-hex-layer\">";
                    color += outputButton + "</div>";
                    line += "<div class=\"button-list-popup button-list-" + key + " popup-clickable\">" +
                        color +
                        "</div>"
                }
                else
                {
                    line += "<div class=\"button-list-popup button-list-" + key + " popup-clickable\">" +
                        outputButton +
                        "</div>"
                }
            }
            line += "</button>";
        });
        return line;
    }
     renderButton()
    {
        return this.renderHtml()
    }
    buttonList()
    {
        return this.buttons;
    }
}