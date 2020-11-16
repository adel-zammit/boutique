<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('carts_finalize') ?>
        </h1>
    </div>
</div>

<div class="action-buy block-with-border">
    <div class="type-table type-head">
        <div class="type-cell cell-designation">Désignation</div>
        <div class="type-cell cell-price type-cell-s">Prix</div>
        <div class="type-cell cell-subtotal type-cell-s">Sous-total</div>
    </div>
    <?php foreach ($params->invoice->Carts as $cart) {?>
        <?= $params->cartRepo->getHtmlCarts($cart->quantity, $cart->Product, $app, [
            'tab' => [
                'designation',
                'price',
                'subtotal'
            ]
        ]) ?>
    <?php } ?>
    <div class="price-total-carts">
        <h2>Total TTC :</h2>
        <div class="display-price">
            <?php if($params->invoice->coupon_id) { ?>
                <h1>
                    <b>
                        <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->total_price)) ?>
                    </b>
                </h1>
                <del class="del-gray"><b><?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->price)) ?></b></del>
            <?php } else {?>
                <h1>
                    <b>
                        <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->total_price)) ?>
                    </b>
                </h1>
            <?php }?>
        </div>
        <?php if($params->invoice->coupon_id) {?>
            <div class="display-coupon" data-coupon-exist="<?= $params->invoice->coupon_id ? true : false ?>">
                Coupon utiliser : <b><?= $params->invoice->Coupon->code ?></b> <?= $params->invoice->Coupon->getCouponPhrase() ?>
            </div>
        <?php } else { ?>
            <div class="display-coupon" data-coupon-exist="">
            </div>
        <?php } ?>
        <div class="coupon-code block-form">
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Coupon :</label>
                    </div>
                </dt>
                <dd>
                    <div class="inputGroup">
                        <input type="text" name="coupon" id="coupon" class="input input-coupon">
                        <span class="inputGroup-splitter"></span>
                        <button class="button button-submit-coupon"> Utiliser </button>
                    </div>
                </dd>
            </dl>
        </div>
        <form action="<?= $app->buildLink('Pub:purchase', ['purchasable_type_id' => 'product'], ['invoice_id' => $params->invoice->invoice_id]) ?>" method="post">
            <input type="hidden" name="payment_profile_id" value="PayPal">
            <button type="submit" class="button">Buy</button>
        </form>
    </div>
</div>
<script>
    var url = '<?= $app->buildLink('Pub:carts/buy/update') ?>';
    $('[data-coupon-exist="1"]').stop(true,true).slideDown()
    $('.button-submit-coupon').click(function () {
        $.ajax({
            url : url,
            method : 'post',
            dataType : 'Json',
            data : {
                code : $('#coupon').val()
            },
            success : (data) => {
                let html = '<div class="block-rowMessage block-rowMessage--' + data.type + ' coupons-message">' +
                     data.error +
                    '</div>'
                if($('.coupons-message').length)
                {
                    $('.coupons-message').remove();
                }
                $('.coupon-code').before(html)
                if(data.type === 'success')
                {
                    $('.display-price').html('<del class="del-gray"><b>' + priceFormat(parseFloat(data.total_price).toFixed(2)) + '</b></del>')
                    $('.display-price').prepend('<h1><b>' + priceFormat(parseFloat(data.price).toFixed(2)) + '</h1></b>');
                    $('.display-coupon').html('Coupon utiliser : <b>' + $('#coupon').val() + '</b> ' + data.value);
                    $('.display-coupon').stop(true,true).slideDown();
                }
            },
            error: function(errorThrown){console.log(errorThrown.responseText)}
        })
    });
</script>