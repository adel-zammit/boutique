<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('invoice') ?>
        </h1>
    </div>
</div>

<div class="invoice block-with-border">
    <div class="invoice-header">
        <div class="invoice-info-company">
            <div class="invoice-info-img">
                <img src="" alt="site">
            </div>
            <div class="invoice-info">
                2 RUE de quelque par, ne chercher pas SVP !
            </div>
        </div>
        <div class="info-invoice-other">
            <div class="info-invoice">
                <h3 class="info-invoice-title">
                    <span class="info-invoice-title-outer">
                        <span class="info-invoice-title-inner">
                            Information
                        </span>
                    </span>
                </h3>
                <dl class="pairs pairs--justified">
                    <dt> N° de facture:</dt>
                    <dd>
                        #<?= $params->invoice->invoice_id ?>
                    </dd>
                </dl>
                <dl class="pairs pairs--justified">
                    <dt> <?= \Base\BaseApp::phrase('state:') ?></dt>
                    <dd>
                        <?= $params->invoice->getState() ?>
                    </dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="type-table type-head">
        <div class="type-cell cell-designation">Désignation</div>
        <div class="type-cell cell-price type-cell-s">Prix</div>
        <div class="type-cell cell-quantity type-cell-s">Quantité</div>
        <div class="type-cell cell-subtotal type-cell-s">Sous-total</div>
    </div>
    <?php foreach ($params->invoice->ItemsPurchased as $item) {?>
        <?= $params->cartRepo->getHtmlCarts($item->quantity, $item->Product, $app, [
            'tab' => [
                'designation',
                'price',
                'subtotal',
                'infQuantity'
            ],
            'displaySock' => false
        ]) ?>
    <?php } ?>
    <div class="total-price">
        <div class="total-price-content">
            <b>Total :</b>
            <?php if($params->invoice->coupon_id) { ?>
                <del><?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->price)) ?></del> <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->total_price)) ?>
            <?php } else { ?>
                <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->total_price)) ?>
            <?php } ?>
        </div>
    </div>
    <?php if($params->invoice->coupon_id && !empty($coupon = $params->invoice->CouponLog)) { ?>
        <div class="coupon block-form">
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Coupon name :</label>
                    </div>
                </dt>
                <dd>
                    <?= $coupon->coupon_name ?>
                </dd>
            </dl>
            <hr class="hr-form">
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Coupon utiliser :</label>
                    </div>
                </dt>
                <dd>
                    <?= $coupon->coupon_code ?>
                </dd>
            </dl>
            <hr class="hr-form">
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Coupon type :</label>
                    </div>
                </dt>
                <dd>
                    <?= \Base\BaseApp::phrase('coupon_' . $coupon->coupon_type) ?>
                </dd>
            </dl>
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Coupon value :</label>
                    </div>
                </dt>
                <dd>
                    <?php if($coupon->coupon_type == 'value') { ?>
                        <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($coupon->coupon_value)) ?>
                    <?php } else {?>
                        <?= $coupon->coupon_value ?>%
                    <?php } ?>
                </dd>
            </dl>
            <hr class="hr-form">
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Prix total (sans coupon) :</label>
                    </div>
                </dt>
                <dd>
                    <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($coupon->total_price)) ?>
                </dd>
            </dl>
            <dl class="form--input">
                <dt>
                    <div class="block-form-label">
                        <label class="form-label" for="coupon">Prix total (avec coupon) :</label>
                    </div>
                </dt>
                <dd>
                    <?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($coupon->price)) ?>
                </dd>
            </dl>
        </div>
    <?php } ?>
</div>