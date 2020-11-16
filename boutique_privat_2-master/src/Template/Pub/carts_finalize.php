<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('carts_finalize') ?>
        </h1>
    </div>
</div>
<div class="cart-content block-with-border">
    <div class="type-table type-head">
        <div class="type-cell cell-designation">Désignation</div>
        <div class="type-cell cell-price type-cell-s">Prix</div>
        <div class="type-cell cell-subtotal type-cell-s">Sous-total</div>
    </div>
    <?php foreach ($params->items as $item) {?>
        <?= $params->cartRepo->getHtmlCarts($item->quantity, $item->Product, $app, [
            'tab' => [
                'designation',
                'price',
                'subtotal'
            ],
            'displaySock' => false
        ]) ?>
    <?php } ?>
    <div class="price-total-carts">
        <h2>Total TTC :</h2>
        <h1><b><?= $params->cartRepo->priceFormat($params->cartRepo->getTwoPartPrice($params->invoice->total_price)) ?></b></h1>
    </div>
</div>