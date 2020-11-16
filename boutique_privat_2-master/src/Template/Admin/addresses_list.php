<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('addresses') ?>
        </h1>
    </div>
</div>
<?= $PageNave->page(['page' => $params->page, 'perPage' => $params->perPage, 'total' => $params->total, 'link' => 'addresses']); ?>
<table class="dataList-table">
    <tbody>
    <?php foreach ($params->addresses as $address) {?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:address', $address) ?>">
                    <div class="dataList-mainRow">
                        <?= $address->name ?>
                        <span class="dataList-hint" dir="auto"><?= $address->first_name  ?> <?= $address->last_name  ?></span>
                        <div class="dataList-subRow">
                            <ul class="dataList-listInline">
                                <li>
                                    <?= $address->User->username ?>
                                </li>
                                <li>
                                    <?= $address->address ?>
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