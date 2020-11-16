<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('coupon_list') ?>
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:coupon/add') ?>"
               class="button button--icon button--icon--add">
                <span class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'coupon']) ?></span></a>
        </div>
    </div>
</div>

<table class="dataList-table">
    <tbody>
    <?php foreach ($params->coupons as $coupon) {?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:coupon/edit', $coupon) ?>">
                    <div class="dataList-mainRow">
                       <?= $coupon->title  ?>
                        <span class="dataList-hint" dir="auto"><?= $coupon->code  ?></span>
                        <div class="dataList-subRow">
                            Valable du <?= \Base\BaseApp::date()->setTimestamp($coupon->start_date)->format('d M Y H:i') ?> au <?= \Base\BaseApp::date()->setTimestamp($coupon->end_date)->format('d M Y H:i') ?>
                        </div>
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>