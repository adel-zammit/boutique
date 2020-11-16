<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('countries_list') ?>
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:sales-tax/add') ?>"
               class="button button--icon button--icon--add">
                <span class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => "taxe"]) ?></span>
            </a>
        </div>
    </div>
</div>

<table class="dataList-table">
    <tbody>
    <?php foreach ($params->countries as $country) {?>
        <tr>
            <td class="dataList-cell dataList-cell--main">
                <a href="<?= $app->buildLink('admin:sales-tax/edit', $country) ?>">
                    <div class="dataList-mainRow">
                        <?= $country->name  ?>
                        <span class="dataList-hint" dir="auto"><?= $country->sales_tax_rate ?></span>
                        <div class="dataList-subRow">
                            <?= $country->native_name ?>
                        </div>
                    </div>
                </a>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>