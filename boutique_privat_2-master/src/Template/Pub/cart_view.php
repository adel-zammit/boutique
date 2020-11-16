<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('carts') ?>
        </h1>
    </div>
</div>
<?php if($params->emptyCarts) {?>
    <div class="cart-content block-with-border">
        <div class="type-table type-head">
            <div class="type-cell cell-designation">Désignation</div>
            <div class="type-cell cell-price type-cell-s">Prix</div>
            <div class="type-cell cell-quantity type-cell-s">Quantité</div>
            <div class="type-cell cell-subtotal type-cell-s">Sous-total</div>
            <div class="type-cell cell-remove">
            </div>
        </div>
        <?php foreach ($params->carts as $cart) {?>
            <?= $params->cartRepo->getHtmlCarts($cart->quantity, $cart->Product, $app) ?>
        <?php } ?>
    </div>
    <div class="action-buy block-with-border">
        <div class="price-total-carts">
            <h2>Total HT :</h2>
            <h1><b><?= $params->cartRepo->getPriceForm() ?></b></h1>
        </div>
        <div class="content-button-buy">
            <a href="<?= isset($_SESSION['user_id']) ? $app->buildLink('Pub:carts/invoice') : $app->buildLink('Pub:login', null, ['redirect' => 'carts']) ?>"
               class="button button-buy <?= isset($_SESSION['user_id']) ? 'button-buy-address' : '' ?>">
                Passer commande
            </a>
        </div>
    </div>
    <script>
        var urlUpdate = "<?= $app->buildLink('Pub:carts/update')?>";
        if($('.item-exceeds-stock').length >= 1)
        {
            $('.p-main-header').after(getMessageError())
        }
        function getMessageError()
        {
            return "<div class=\"blockMessage blockMessage--error blockMessage--iconic no-popup\">\n" +
                "    Dans votre panier il y a un ou plusieurs produit qui ne sont plus en stock, ou qu'il y pas la quantité demander!\n" +
                "</div>";
        }
        function getOptionByQuantify(quantity, value)
        {
            let output = '';
            for(let i = 1; i <= quantity; ++i)
            {
                let selection = value === i ? 'selected' : '';
                output += '<option value="' + i + '" ' + selection + ' >' + i + '</option>';
            }
            if( quantity < value)
            {
                console.log(quantity)
                output += '<option value="' + quantity + '" selected >' + quantity + '</option>';
            }
            return output;
        }
        $(document).ready(() => {
            $('.remove-action').click(function () {
                let parent = $(this).closest('.item')
                $.ajax({
                    url : $(this).attr('href'),
                    method : 'get',
                    dataType : 'json',
                    success : (data) => {
                        console.log(data.emptyCarts)
                        if(data.emptyCarts === 0)
                        {
                            window.location.reload();
                        }
                        parent.remove();
                        $('.price-total-carts h1 b').html(priceFormat(data.totalPrice));
                    },
                    error: function(errorThrown){console.log(errorThrown.responseText)}
                });
                return false;
            });
            $('.quantity-input').change(function () {
                let parent = $(this).closest('.item');
                let priceProduct = parent.find('.cell-price .price').data('price');
                let quantity = parseInt($(this).val());
                priceProduct = parseFloat(priceProduct);
                let price = priceProduct * quantity;
                let result = priceFormat(price);
                parent.find('.cell-subtotal .price').html(result);
                $.ajax({
                    url : urlUpdate,
                    method : 'post',
                    dataType : 'json',
                    data : {
                        productId : parent.data('product-id'),
                        quantity : quantity
                    },
                    success : (data) => {
                        let inputSelect = parent.find('.cell-quantity .quantity-input')
                        $('.price-total-carts h1 b').html(priceFormat(data.totalPrice));
                        if(inputSelect.find('option').length > data.stocks)
                        {
                            let optionValue = getOptionByQuantify(data.stocks, quantity)
                            inputSelect.html(optionValue);
                            if( data.stocks >= quantity)
                            {
                                parent.removeClass('item-exceeds-stock');
                                let classStock = parent.find('.cell-designation .type-cell-txt .stocks')
                                classStock.removeClass('hor-stock');
                                classStock.addClass('in-stock');
                                if($('.item-exceeds-stock').length === 0)
                                {
                                    $('.blockMessage').remove();
                                }
                            }
                        }
                    },
                    error: function(errorThrown){console.log(errorThrown.responseText)}
                });
            });
            $('.button-buy-address').click(function () {
                $.ajax({
                    url : $(this).attr('href'),
                    method : 'get',
                    dataType : 'json',
                    success : (data) => {
                        window.location.replace(data.url);
                    },
                    error: function(errorThrown){console.log(errorThrown.responseText)}
                });
                return false;
            })
        })
    </script>
<?php } else {?>
    <div class=" block-with-border">
        Votre panier est vide…
    </div>
<?php } ?>
