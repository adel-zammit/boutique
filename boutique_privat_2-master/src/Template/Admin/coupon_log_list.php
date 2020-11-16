<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('coupon_log_list') ?>
        </h1>
    </div>
</div>
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'log/coupon']); ?>
<table class="dataList-table">
    <tbody>
    <?php foreach ($params->couponsLogs as $couponLog) {?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:log/coupon', $couponLog) ?>" data-overlay-info="true">
                    <div class="dataList-mainRow">
                        <?= $couponLog->coupon_name  ?>
                        <span class="dataList-hint" dir="auto"><?= $couponLog->coupon_code  ?></span>
                        <div class="dataList-subRow">
                            <ul class="dataList-listInline">
                                <li>
                                    <?= \Base\BaseApp::renderHtmlDate($couponLog->coupon_date) ?>
                                </li>
                                <li>
                                    <?= $couponLog->username ?>
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