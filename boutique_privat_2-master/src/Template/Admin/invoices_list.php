<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('orders') ?>
        </h1>
    </div>
</div>
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/order']); ?>
<table class="dataList-table">
    <tbody>
    <?php foreach ($params->invoices as $invoice) {?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:log/order', $invoice) ?>" data-overlay-info="true">
                    <div class="dataList-mainRow">
                        <?= \Base\BaseApp::phrase('order') ?> #<?= $invoice->invoice_id ?> (<?= $invoice->getTotalPrice() ?>)
                        <span class="dataList-hint" dir="auto"><?= $invoice->getSateLite()  ?></span>
                        <div class="dataList-subRow">
                            <ul class="dataList-listInline">
                                <li>
                                    <?= \Base\BaseApp::renderHtmlDate($invoice->invoice_date) ?>
                                </li>
                                <li>
                                    <?= $invoice->User->username ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/order']); ?>