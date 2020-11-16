<div class="CanvasMenu">
    <div class="menu-nav-left"></div>
    <div class="menu-nav-right">
        <div class="CanvasMenu-content">
            <div class="CanvasMenu-header">
                Menu
                <span class="CanvasMenu-close"></span>
            </div>
            <div class="CanvasMenu-nav CanvasMenu-cat <?=  in_array($_SESSION['currentPage'], ['category', 'technical-data-sheet', 'address']) ? 'active' : ''; ?>">
                <div class="CanvasMenu-titre">
                    <i class="far fa-sliders-h fa-fw"></i> Setup <span class="CanvasMenu-open"></span>
                </div>
                <div class="CanvasMenu-all-item" <?=  in_array($_SESSION['currentPage'], ['category', 'technical-data-sheet', 'address']) ? 'style="display: block;"' : ''; ?>>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'category' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:category') ?>"> Categorie</a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'technical-data-sheet' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:category/technical-data-sheet') ?>"> Fiche téchnique</a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'address' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:address') ?>"> <?= \Base\BaseApp::phrase('addresses') ?></a>
                    </div>
                </div>
            </div>
            <div class="CanvasMenu-nav CanvasMenu-cat <?=  in_array($_SESSION['currentPage'], ['product', 'coupon', 'sales-tax']) ? 'active' : ''; ?>">
                <div class="CanvasMenu-titre">
                    <i class="fas fa-project-diagram fa-fw"></i> Produit <span class="CanvasMenu-open"></span>
                </div>
                <div class="CanvasMenu-all-item" <?=  in_array($_SESSION['currentPage'], ['product', 'coupon', 'sales-tax']) ? 'style="display: block;"' : ''; ?>>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'product' ? 'is-current-page' : ''; ?>" >
                        <a href="<?= $app->buildLink('admin:product') ?>"> Produit liste</a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'coupon' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:coupon') ?>"> Coupon</a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'sales-tax' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:sales-tax') ?>"> <?= \Base\BaseApp::phrase('sales_tax_rate') ?></a>
                    </div>
                </div>
            </div>
            <div class="CanvasMenu-nav CanvasMenu-cat <?=  in_array($_SESSION['currentPage'], ['log-coupon', 'log-order', 'log-payment', 'log-addresses']) ? 'active' : ''; ?>">
                <div class="CanvasMenu-titre">
                    <i class="far fa-history fa-fw" aria-hidden="true"></i> Log <span class="CanvasMenu-open"></span>
                </div>
                <div class="CanvasMenu-all-item" <?=  in_array($_SESSION['currentPage'], ['log-coupon', 'log-order', 'log-payment', 'log-addresses']) ? 'style="display: block;"' : ''; ?>>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'log-coupon' ? 'is-current-page' : ''; ?>" >
                        <a href="<?= $app->buildLink('admin:log/coupon') ?>"> <?= \Base\BaseApp::phrase('coupon_log') ?></a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'log-addresses' ? 'is-current-page' : ''; ?>" >
                        <a href="<?= $app->buildLink('admin:log/addresses') ?>"> <?= \Base\BaseApp::phrase('addresses_log') ?></a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'log-order' ? 'is-current-page' : ''; ?>" >
                        <a href="<?= $app->buildLink('admin:log/order') ?>"> <?= \Base\BaseApp::phrase('orders') ?></a>
                    </div>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'log-payment' ? 'is-current-page' : ''; ?>" >
                        <a href="<?= $app->buildLink('admin:log/payment') ?>"> <?= \Base\BaseApp::phrase('payment_provider_list') ?></a>
                    </div>
                </div>
            </div>
            <div class="CanvasMenu-nav CanvasMenu-cat <?=  in_array($_SESSION['currentPage'], ['cron']) ? 'active' : ''; ?>">
                <div class="CanvasMenu-titre">
                    <i class="far fa-wrench fa-fw" aria-hidden="true"></i> Tools <span class="CanvasMenu-open"></span>
                </div>
                <div class="CanvasMenu-all-item" <?=  in_array($_SESSION['currentPage'], ['cron']) ? 'style="display: block;"' : ''; ?>>
                    <div class="CanvasMenu-item <?= $_SESSION['currentPage'] == 'cron' ? 'is-current-page' : ''; ?>">
                        <a href="<?= $app->buildLink('admin:cron') ?>"> <?= \Base\BaseApp::phrase('cron') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>