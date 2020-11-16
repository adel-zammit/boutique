<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('product_list') ?>
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:product/categories') ?>"
               class="button button--icon button--icon--add" data-overley-form="true">
                <span class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'produit']) ?></span></a>
        </div>
    </div>
</div>
<div class="block-with-border search-product">
    <input type="text" name="search" class="input" id="filter-search">
    <div class="filter-category">
        <div class="filter-category-title">
            Categories <i class="fas fa-caret-down"></i>
            <input type="hidden" name="category_id" id="categoryId">
        </div>
        <div class="filter-category-content">
            <ul>
                <li class="content-category is-category-select" data-category-id="">
                    <div class="u-depth">
                        (Tous)
                    </div>
                </li>
                <?php foreach ($params->categoryTree as $entryTree) {?>
                    <li class="content-category" data-category-id="<?= $entryTree->category_id ?>">
                        <div class="u-depth<?= $entryTree->depth ?>">
                            <?= $entryTree->name ?>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="filter-stock">
        <ul class="input-check-box">
            <li class="input-check-box-choice">
                <label class="check-box">
                    <input type="checkbox" name="stock" id="filter-stock" data-hide="true">
                    <i aria-hidden="true"></i>
                    <span class="radio-label">Pas de stock</span>
                </label>
            </li>
        </ul>
    </div>
</div>
<div class="block-with-border">
    <div class="products-list">
        <div class="product-info-list">
            <div class="product-img"></div>
            <div class="product-list-style product-title">
                Title
            </div>
            <div class="product-list-style" >
                Stock
            </div>
            <div class="product-list-style">
                Price
            </div>
            <div class="product-list-style">
                Category
            </div>
            <div class="product-list-style lite-case"></div>
            <div class="product-list-style lite-case"></div>
        </div>
        <div class="products-list-inner">
            <div class="products-list-content">
                <?php foreach ($params->products as $product) { ?>
                    <div class="product-list" data-product-id="<?= $product->product_id ?>">
                        <div class="product-img">
                            <?= \Base\Util\Img::getImg($product, 'icon_date', 'defaultProduct', 'default_img_product', 'm') ?>
                        </div>
                        <div class="product-list-style product-title" data-content-type="title" data-type-input="str">
                            <?= $form->getTextBox('title', $product->title) ?>
                        </div>
                        <div class="product-list-style product-stock" data-content-type="stock" data-type-input="int">
                            <?= $form->getInputNumber('stock', $product->stock, false, 1) ?>
                        </div>
                        <div class="product-list-style product-price" data-content-type="price" data-type-input="float">
                            <?= $form->getInputNumber('price', $product->price, false, 0.01) ?>
                        </div>
                        <div class="product-list-style product-category" data-content-type="category" data-type-input="int">
                            <select name="category" class="input" id="type">
                                <option value="0" <?= !$product->category_id ? 'selected' : '' ?>><?= Base\BaseApp::phrase('(none)') ?></option>
                                <?php foreach ($params->categories as $category) {?>
                                    <option value="<?= $category['value'] ?>" <?= $product->category_id == $category['value'] ? 'selected' : '' ?> > <?= $category['label'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="product-edit lite-case">
                            <a href="<?= $app->buildLink('admin:product/edit', $product) ?>">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                        <div class="product-remove lite-case">
                            <a href="<?= $app->buildLink('admin:product/delete', $product) ?>" data-overley="true">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>
<script>
    var urlUpdateProduct = "<?= $app->buildLink('admin:product/update-product') ?>";
    var urlScroll  = "<?= $app->buildLink('admin:product/scroll') ?>";
    var urlSearch  = "<?= $app->buildLink('admin:product/search') ?>";
    var offset = 1;
    var perPage = 20;
    var total = <?= $params->total ?>;
    var deviceAgent = navigator.userAgent.toLowerCase();
    var agentID = deviceAgent.match(/(iphone|ipod|ipad)/);
    function renderProductsList(value, category) {
        let html = '<div class="product-list" data-product-id="' + value.id + '">'
        html += '<div class="product-img">'
        html += value.img;
        html += '</div>';
        html += '<div class="product-list-style product-title" data-content-type="title" data-type-input="str">';
        html += getTextBox('title', {
            value : value.title
        });
        html += '</div>';
        html += '<div class="product-list-style product-stock" data-content-type="stock" data-type-input="int">';
        html += getInputNumber('stock', {
            value : value.stock,
            min : 0,
        });
        html += '</div>';
        html += '<div class="product-list-style product-price" data-content-type="price" data-type-input="float">';
        html += getInputNumber('price', {
            value : value.price,
            min : 0,
            step : 0.01
        });
        html += '</div>';
        html += '<div class="product-list-style product-category" data-content-type="category" data-type-input="int">';
        let selectors = [];
        selectors[0] = {
            selected : (!value.value),
            label : '(none)'
        };
        $.each(category, function (key, valueSelector) {
            selectors[key] = {
                selected : (valueSelector.value === value.categoryId),
                label : valueSelector.label
            }
        });
        html += getSelectorByArray('category', {options : selectors});
        html += '</div>';
        html += '<div class="product-edit lite-case">';
        html += '<a href="' + value.urlEdit + '" >'
        html += '<i class="fas fa-edit"></i>'
        html += '</a>'
        html += '</div>';
        html += '<div class="product-remove lite-case">';
        html += '<a href="' + value.urlDelete + '"  data-overley="true">'
        html += '<i class="far fa-trash-alt"></i>'
        html += '</a>'
        html += '</div>';
        html += '</div>';
        return html;
    }
    function updateProduct(content, value)
    {
        let parent = content.closest('.product-list');
        let parentContent = content.closest('.product-list-style');
        $.ajax({
            url : urlUpdateProduct,
            method : 'post',
            data : {
                productId : parent.data('product-id'),
                contentType : parentContent.data('content-type'),
                value : value,
                typeInput : parentContent.data('type-input')
            }

        })
    }
    function callback()
    {
        $('.products-list-inner .spinner-button').click(function () {
            let parentContent = $(this).closest('.product-list-style');
            updateProduct($(this), parentContent.find('.input').val());
        });
        $('.products-list-inner .input').focusout(function () {
            updateProduct($(this), $(this).val());
        });
    }
    callback();
    $('.products-list-inner').scroll(function () {
        if(($(this).scrollTop() + $(this).height()) === $(this).find('.products-list-content').height() && (offset * perPage <= total)) {
            ++offset;
            let stock = false;
            if ($('#filter-stock').is(":checked"))
            {
                stock = true;
            }
            $.ajax({
                url : urlScroll,
                method: 'post',
                data : {
                    offset : offset,
                    filterText : $('#filter-search').val(),
                    categoryId : $('#categoryId').val(),
                    stock : stock ? 2 : 1
                },
                dataType : 'json',
                success : (data) => {
                    data.products.forEach((value,key) => {
                        $('.products-list-content').append(renderProductsList(value, data.categories))
                    });
                    callback();
                    ajaxDelete();
                },
                error: function(errorThrown){console.log(errorThrown.responseText)}
            });
        }
    });
    function searchAjax(q, categoryId, stock)
    {
        $.ajax({
            url : urlSearch,
            method : 'post',
            dataType : 'json',
            data : {
                q : q,
                offset : offset,
                categoryId : categoryId,
                stock : stock
            },
            success : (data) => {
                let outputHtml = '';
                data.products.forEach((value,key) => {
                    outputHtml += renderProductsList(value, data.categories);
                });
                total = data.total;
                $('.products-list-content').html(outputHtml)
                callback();
                ajaxDelete();
            },
            error: function(errorThrown){console.log(errorThrown.responseText)}
        })
    }
    $('#filter-search').on('input', function () {
        let value = $(this).val();
        let stock = false;
        if ($('#filter-stock').is(":checked"))
        {
            stock = true;
        }
        searchAjax(value, $('#categoryId').val(), stock ? 2 : 1)
    });
    $('.content-category').click(function () {
        let value = $(this).data('category-id');
        let q = $('#filter-search').val();
        $('#categoryId').val(value);
        let parent = $(this).closest('.filter-category');
        if(parent.find('.filter-category-title').hasClass('active-category'))
        {
            parent.find('.filter-category-title').removeClass('active-category');
            parent.find('.filter-category-content').stop(true,true).slideUp(100);
        }
        $.each($('.content-category'), function () {
            if($(this).hasClass('is-category-select'))
            {
                $(this).removeClass('is-category-select');
            }
        });
        $(this).addClass('is-category-select');
        let stock = false;
        if ($('#filter-stock').is(":checked"))
        {
            stock = true;
        }
        searchAjax(q, value, stock ? 2 : 1)
    });
    $('#filter-stock').change(function() {
        let q = $('#filter-search').val();
        searchAjax(q, $('#categoryId').val(), this.checked ? 2 : 1)
    });
    $('.filter-category-title').click(function () {
        if($(this).hasClass('active-category'))
        {
            $(this).removeClass('active-category');
            $('.filter-category-content').stop(true,true).slideUp(100);
        }
        else
        {
            $(this).addClass('active-category');
            $('.filter-category-content').stop(true,true).slideDown(100);
        }
    });
</script>