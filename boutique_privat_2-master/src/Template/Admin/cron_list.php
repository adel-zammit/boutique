<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            Cron list
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:cron/add') ?>" class="button button--icon button--icon--add" data-overley-form="true"><span
                    class="button-text"> Add cron</span></a>
        </div>
    </div>
</div>

<table class="dataList-table">
    <tbody>
    <?php if(!empty($params->cronS)) {?>
        <?php foreach ($params->cronS as $cron) {
            ?>
            <tr>
                <td class="dataList-cell dataList-cell--main">
                    <a href="<?= $app->buildLink('admin:cron/edit', $cron) ?>" data-overley-form="true">
                        <div class="dataList-mainRow">
                            <?= $cron->title ?>
                        </div>
                        <div class="dataList-subRow">
                            <?= $cron->description ?>
                        </div>
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--iconic dataList-cell--alt dataList-cell--action">
                    <a href="<?= $app->buildLink('admin:cron/execute', $cron) ?>" class="iconic iconic--sync dataList-sync"
                       >
                        <i aria-hidden="true"></i>
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--iconic dataList-cell--alt dataList-cell--action">
                    <a href="<?= $app->buildLink('admin:cron/deleted', $cron) ?>" class="iconic iconic--delete dataList-delete"
                       data-overley="true">
                        <i aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>