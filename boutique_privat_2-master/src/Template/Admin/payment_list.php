<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('payment_provider_list') ?>
        </h1>
    </div>
</div>
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/payment']); ?>
<table class="dataList-table">
    <tbody>
    <?php foreach ($params->payments as $payment) {
        $PurchaseRequest = $payment->PurchaseRequest;
        ?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:log/payment', $payment) ?>" data-overlay-info="true">
                    <div class="dataList-mainRow">
                        <?= \Base\BaseApp::phrase('log_type_' . $payment->log_type . ':') ?> <?= $payment->log_message  ?>
                        <div class="dataList-subRow">
                            <ul class="dataList-listInline">
                                <li>
                                    <?= $payment->provider_id ?>
                                </li>
                                <li>
                                    <?= \Base\BaseApp::phrase('payment_type_' . $PurchaseRequest->purchasable_type_id) ?>
                                </li>
                                <li>
                                    <?= \Base\BaseApp::renderHtmlDate($payment->log_date) ?>
                                </li>
                                <li>
                                    <?= $PurchaseRequest->User->username ?>
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
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/payment']); ?>