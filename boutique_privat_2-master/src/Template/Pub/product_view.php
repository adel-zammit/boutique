<div class="nav-product block-with-border">
    <div class="nav-product-style price-product">
        <?= $params->product->price ?> €
    </div>
    <div class="nav-product-style stock-product">
        <?php if($params->product->stock) {?>
            <span class="content-stock"></span>
            En stock
        <?php } else {?>
            <span class="content-hor-stock"></span>
            Rupture de stock
        <?php } ?>
    </div>
    <div class="nav-product-style purchasable-product">
        <button class="button" id="product-buy" data-url-buy="<?=$app->buildLink('Pub:product/buy', $params->product) ?>" data-max-buy="<?= $params->product->stock ?>" <?= $params->product->stock ? '' : 'disabled' ?>>
            Acheter
        </button>
    </div>
</div>

<div class="header-product block-with-border">
    <div class="header-product-other">
        <div class="header-product-content">
            <?= Base\Util\Img::getImg($params->product, 'icon_date', 'defaultProduct', 'default_img_product', 'xxl') ?>
        </div>
        <div class="header-product-content header-product-info">
            <h3><?= $params->product->title ?></h3>
            <ul class="gallery-items">
                <?php foreach ($params->product->ProductImg as $imgId => $img)  { ?>
                    <li class="gallery-item" data-attachment-id="<?= $imgId ?>">
                        <a data-lb-sidebar-href="" data-lb-caption-extra-html="" data-fancybox="gallery"
                           href="<?= $img->getUrlLogoBypath() ?>"
                           class="file-preview js-lbImage"
                           data-caption="<h4><?=  $img->name ?></h4><p><a href=&quot;&quot; class=&quot;js-lightboxCloser&quot;></a></p>"
                        >
                            <img src="<?= $img->getUrlLogoBypath() ?>"
                                 alt="<?=  $img->name ?>"
                                 class="img-item"
                                 width="588" height="300">
                        </a>
                        <div class="file-content">
                            <div class="file-info">
                                <span class="file-name" title="<?= $img->name ?>"><?= $img->name ?></span>
                                <div class="file-meta">
                                    <?= Base\BaseApp::FileGetSize($img->getUrlLogo()) ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="xs-display" data-rating="<?= $params->product->review_total ?>">

        </div>
    </div>
    <div class="block-tab">
        <ul>
            <li data-tab-id="block-description" data-current-active="true">
                Description
            </li>
            <li data-tab-id="technical-data-sheet" data-current-active="false">
                Fiche téchnique
            </li>
            <li data-tab-id="tab-rating" data-current-active="false">
                Avie (<?= $params->reviews->count() ?>)
            </li>
        </ul>
    </div>
</div>

<div class="block-tab-content">
    <div class="block-tab-style block-with-border" id="block-description">
        <?= Base\Util\MessageBbCode::parser($params->product->description) ?>
    </div>
    <div class="block-tab-style block-with-border"  id="technical-data-sheet">
        <?php foreach ($params->product->TechnicalDataSheetValues as $TechnicalDataSheetValue) { ?>
            <div class="technical-data-sheet-content">
                <div class="technical-data-sheet-title">
                    <?= $TechnicalDataSheetValue->TechnicalDataSheet->title ?>
                </div>
                <div class="technical-data-sheet-value">
                    <?= Base\Util\MessageBbCode::parser($TechnicalDataSheetValue->value) ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="block-tab-style" id="tab-rating">
        <?php if(\Base\BaseApp::visitor()->user_id && $params->testBuyArticle && !$params->reviews->count()) { ?>
            <div class="block-form-other">
                <form action="<?= $app->buildLink('Pub:product/avie', $params->product) ?>" method="post" class="form-submit-ajax">
                    <dl class="form--input first">
                        <dt>
                            <div class="block-form-label">
                                <label class="form-label" for="login">Rating</label>
                            </div>
                        </dt>
                        <dd>
                            <div class="xs-select xs-theme-stars xs-widget--withSelected">

                            </div>
                        </dd>
                    </dl>
                    <dl class="form--input">
                        <dt>
                            <div class="block-form-label">
                                <label class="form-label" for="review">Review</label>
                                <dfn class="form-hint">Requis</dfn>
                            </div>
                        </dt>
                        <dd>
                            <textarea name="review" rows="5" class="input"></textarea>
                        </dd>
                    </dl>
                    <input type="hidden" id="refresh-form" value="1">
                    <div class="formSubmitRow-main">
                        <div class="formSubmitRow-controls">
                            <button type="submit" class="button"><i class="far fa-star fa-space-1x"></i> Soumettre l'évaluation</button>
                        </div>
                    </div>
                </form>
            </div>
        <?php } ?>
        <div class="content-reviews-other">
            <?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'product', 'data' => $params->product, 'hashtag' => 'tab-rating']); ?>
            <div class="content-reviews block-with-border">
                <?php if($params->reviews->count()) { ?>
                    <?php foreach ($params->reviews as $review) { ?>
                        <div class="content-review">
                            <div class="message-cell message-cell--main">
                                <div class="message-content">
                                    <div class="message-attribution">
                                        <ul class="listInline">
                                            <li class="message-attribution-user">
                                                <?= !empty($review->User) ? $review->User->username : $review->username ?>
                                            </li>
                                            <li class="xs-displays" data-rating="<?= $review->rating ?>">
                                            </li>
                                            <li>
                                                <?= \Base\BaseApp::renderHtmlDate($review->review_date) ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="message-body">
                                        <?= $review->review ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="blockMessage">
                        Aucun avis pour ce produit.
                    </div>

                <?php } ?>
            </div>
            <?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'product', 'data' => $params->product, 'hashtag' => 'tab-rating']); ?>
        </div>
    </div>
</div>

<script>
    var rating = new Rating('.xs-select', {
        value : {
            1 : 'Pas terrible',
            2 : 'Pas top',
            3 : 'Moyenne',
            4 : 'Bien',
            5 : 'Excellent',
        },
        name : 'rating',
        rowClass : ''
    });
    var displays = new Rating('.xs-displays', {
            numberStar : 5,
            rowClass : '',
            dataName : 'rating'
        },
        'displays'
    );
    var display = new Rating('.xs-display', {
            numberStar : 5,
            rowClass : '',
            dataName : 'rating'
        },
        'display'
    );
    $(document).ready(() => {
        $('#product-buy').click(function () {
            let url = $(this).data('url-buy');
            let max = $(this).data('max-buy');
            let classView = $('.get-view');
            $('.get-view .popup-title').html('Confirmation');
            classView.addClass('active-overlay')
                .animate({opacity:1},
                    {duration: 100})
                .find('.blockMessage').css('padding', '0').html(renderContentBuy(url, max));
            classView.find('form').css('width', '100%');
            getFormAjax(10000000000)
        });
        $('.get-view .js-overlayClose').click(function () {
            leavePopup($('.get-view'));
        });
        $('.get-view').click(function(e) {
            $div =  $(this).find('.overlay');
            if(!$(e.target).is($div) && !$.contains($div[0],e.target))
            {
                leavePopup($(this));
            }
        });
    });
    function renderContentBuy(url, max) {
        let html = '<div class="block-form">';
        html += '<div class="block-miner">';
        html += '<form action="' + url + '" method="post" class="form-submit-ajax form-submit-action">';
        html += '<div class="p-form">';
        html += '<label class="form-label">Quantité:</label>';
        html += getInputNumber('quantity', {
            required : true,
            min : 1,
            max : max,
            step : 1,
            value : 1
         });
        html += "</div>";
        html += '<div class="form-submit"><div class="form-submit-controls">\n' +
            '          <button type="submit" name="content_type" value="shopping" class="button count_input_more"> Voir mon panier</button>\n' +
            '          <button type="submit" name="content_type" value="continue" class="button count_input_more"> Continuer mes achats</button>\n' +
            '     </div></div>';
        html += '</form>';
        html += '</div>';
        html += '</div>';
        return html;
    }
</script>