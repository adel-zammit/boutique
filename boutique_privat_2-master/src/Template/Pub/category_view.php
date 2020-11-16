<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= $params->category->name ?>
        </h1>
    </div>
</div>

<div class="content-products-category">
    <div class="content-products-sidebar">
        <div class="block-content-sidebar block-with-border">
            <h3 class="block-minorHeader"><?= \Base\BaseApp::phrase('categories') ?></h3>
            <div class="sidebar-content">
                <ol class="categoryList toggleTarget">
                    <?php
                    /** @var \App\Entity\Categories $category */
                    foreach ($params->categoryTree->categoryByDepth()  as $category) {
                        $output = [];
                        $child = $params->categoryTree->treeCategory([$category], $output, 1);
                        ?>
                            <li class="categoryList-item <?= $category->category_id == $params->category->category_id ? 'is-active-parent' : ''  ?> master-category" data-show="<?= $category->category_id == $params->category->category_id  ?>">
                                <a class="categoryList-toggler <?= $category->category_id == $params->category->category_id ? 'is-active' : ''  ?>" data-xf-click="toggle" role="button" tabindex="0"></a>
                                <a href="<?= $app->buildLink('Pub:product/categories', $category) ?>"><?= $category->name ?></a>
                                <ol class="categoryList" tabindex="-1">
                                    <?php foreach ($child as $childCategory ) {?>
                                        <li class="categoryList-item"  data-show-category="<?= $childCategory->category_id == $params->category->category_id  ?>">
                                            <span class="categoryList-togglerSpacer"></span>
                                            <a href="<?= $app->buildLink('Pub:product/categories', $childCategory) ?>" class="categoryList-link">
                                                <?= $childCategory->name ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ol>
                            </li>
                    <?php } ?>
                </ol>
            </div>
        </div>

        <div class="block-content-sidebar block-with-border">
            <h3 class="block-minorHeader">Price
                <?php if(!empty($params->filter['min_price']) || !empty($params->filter['max_price'])) { ?>
                    <a class="delete-filter" data-filter-delete="min_price,max_price" data-delete-message="Supprimer filtre">
                        <span class="delete-filter-logo"></span>
                        <span class="delete-filter-content"></span>
                    </a>
                <?php } ?>
            </h3>
            <div class="filter-price sidebar-content">

                <div class="content-filter">
                    <div class="rule-slider">
                        <div class="event-click-slider"></div>
                        <div class="handle min" data-value-max="<?= $params->max ?>" data-value="<?= $params->min ?>"><?= $params->min ?>€</div>
                        <div class="bar-slider"></div>
                        <div class="handle max" data-value-min="<?= $params->min ?>" data-value="<?= $params->max ?>"><?= $params->max ?>€</div>
                    </div>
                </div>
                <input class="input-min input-filter-style input" value="<?= empty($params->min) ? 0.00 : $params->min ?>" name="min_price">
                <input class="input-max input-filter-style input"  value="<?= empty($params->max) ? 0.00 : $params->max  ?>" name="max_price">
            </div>
            <div class="filter-footer">
                <button class="button button-save-filter type-price">Filter</button>
            </div>
        </div>
        <div class="block-content-sidebar block-with-border">
            <h3 class="block-minorHeader">Evalution
                <?php if(!empty($params->filter['rating'])) { ?>
                    <a class="delete-filter" data-filter-delete="rating" data-delete-message="Supprimer filtre">
                        <span class="delete-filter-logo"></span>
                        <span class="delete-filter-content"></span>
                    </a>
                <?php } ?>
            </h3>
            <div class="filter-star sidebar-content">
                <div class="xs-select xs-theme-stars xs-widget--withSelected xs-widget-filters" data-filter-rating="<?= empty($params->filter['rating']) ? 0.00 : $params->filter['rating'] ?>">

                </div>
            </div>
            <div class="filter-footer">
                <button class="button button-save-filter type-rating">Filter</button>
            </div>
        </div>
    </div>
    <div class="content-products-list">
        <?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'product/categories', 'data' => $params->category, 'params' => $params->filter]); ?>
        <div class="list-product">
            <?php foreach ($params->products as $product) { ?>
                <div class="product-content block-with-border">
                    <header class="product-img">
                        <div class="content-product-img">
                            <div  class="content-product-img-inner">
                                <div class="content-product-img-other">
                                    <?= \Base\Util\Img::getImg($product, 'icon_date', 'defaultProduct', 'default_img_product', 'l', $app->buildLink('Pub:product', $product)) ?>
                                </div>

                            </div>
                        </div>
                    </header>
                    <div class="product-info">
                        <h3 class="product-title">
                            <a href="<?= $app->buildLink('Pub:product', $product)?>" >
                                <?= $product->title ?>
                            </a>
                        </h3>
                        <div class="product-more-info">
                           <span class="price">
                               Price : <?= $product->price ?> €
                           </span>
                            <div class="product-more-info-other">
                                <div class="xs-displays" data-rating="<?= $product->review_total ?>">

                                </div>
                                <div class="product-more-info-stock">
                                    <?php if($product->stock) {?>
                                        <span data-toggle="tooltip" data-tooltip-title="En stock" class="content-stock"></span>
                                    <?php } else {?>
                                        <span data-toggle="tooltip" data-tooltip-title="Rupture de stock" class="content-hor-stock"></span>
                                    <?php } ?>
                                </div>
                            </div>

                        </div>
                    </div>
                    <footer class="footer-card-product">
                        <div class="footer-product-content">
                            Post Date : <?= \Base\BaseApp::renderHtmlDate($product->product_date) ?>
                        </div>
                    </footer>
                </div>
            <?php } ?>
        </div>
        <?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'product/categories', 'data' => $params->category, 'params' => $params->filter]); ?>
    </div>
</div>
<script type="text/javascript" src="<?= \Base\BaseApp::getBaseLink() ?>Styles/js/categories.js"></script>

