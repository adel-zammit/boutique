<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('addresses_log') ?>
        </h1>
    </div>
</div>

<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/coupon']); ?>
    <table class="dataList-table">
        <tbody>
        <?php foreach ($params->addressesLog as $addressLog) {?>
            <tr>
                <td class="dataList-cell dataList-cell--main">
                    <a href="<?= $app->buildLink('admin:log/addresses', $addressLog) ?>" data-overlay-info="true">
                        <div class="dataList-mainRow">
                            <?= $addressLog->address_name  ?>
                            <span class="dataList-hint" dir="auto"><?= $addressLog->first_name  ?> <?= $addressLog->last_name  ?></span>
                            <div class="dataList-subRow">
                                <ul class="dataList-listInline">
                                    <li>
                                        <?= \Base\BaseApp::renderHtmlDate($addressLog->log_date) ?>
                                    </li>
                                    <li>
                                        <?= $addressLog->User->username ?>
                                    </li>
                                    <li>
                                        <?= $addressLog->address ?>
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
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/coupon']); ?>