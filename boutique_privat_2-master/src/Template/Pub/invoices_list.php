<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('invoices') ?>
        </h1>
    </div>
</div>
<?php $user = \Base\BaseApp::visitor(); ?>
<div class="block-tab">
    <ul>
        <a href="<?= $app->buildLink('Pub:account') ?>">
            <li >
                Information de base
            </li>
        </a>
        <a href="<?= $app->buildLink('Pub:account') ?>#tab-default-password">
            <li>
                Password
            </li>
        </a>
        <a href="<?= $app->buildLink('Pub:address') ?>#tab-default-password">
            <li>
                <?=  \Base\BaseApp::phrase('address') ?>
            </li>
        </a>
        <li>
            <?=  \Base\BaseApp::phrase('invoices') ?>
        </li>
    </ul>
</div>
<table class="dataList-table">
    <tbody>
    <?php if($params->invoices) {
        $i = 1;
        ?>
        <?php foreach ($params->invoices as $invoiceId => $invoice) {?>
            <tr>
                <td class="dataList-cell dataList-cell--min dataList-cell--link">
                    <a href="<?= $app->buildLink('Pub:invoices', $invoice) ?>">
                        #<?= $i ?>
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--main">
                    <a href="<?= $app->buildLink('Pub:invoices', $invoice) ?>">
                        <div class="dataList-mainRow ">
                            N° <?= $invoiceId ?>
                            <span class="dataList-hint" dir="auto"><?= \Base\BaseApp::renderHtmlDate($invoice->invoice_date) ?></span>
                            <div class="dataList-subRow">
                                <?= $invoice->getState() ?>
                            </div>
                        </div>
                    </a>
                </td>
            </tr>
        <?php ++$i; } ?>
    <?php } else { ?>
        <tr>
            <td class="dataList-cell dataList-cell--main dataList-cell-error">
                <?= \Base\BaseApp::phrase('there_are_no_categories_created') ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>