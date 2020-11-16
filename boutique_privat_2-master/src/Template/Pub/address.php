<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('address') ?>
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
        <li>
            <?=  \Base\BaseApp::phrase('address') ?>
        </li>
        <a href="<?= $app->buildLink('Pub:invoices') ?>#tab-default-password">
            <li>
                <?=  \Base\BaseApp::phrase('invoices') ?>
            </li>
        </a>
    </ul>
    <a href="<?= $app->buildLink('Pub:address/add', null, ['redirect' => 'carts/address']) ?>"
       class="button button--icon button--icon--add"  data-overley-form="true">
        <span class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'address']) ?></span>
    </a>
</div>
<table class="dataList-table">
    <tbody>
    <?php if($params->addresses) { ?>
        <?php foreach ($params->addresses as $address) {?>
            <tr>
                <td class="dataList-cell dataList-cell--main">
                    <a href="<?= $app->buildLink('Pub:address/edit', $address) ?>" data-overley-form="true">
                        <div class="dataList-mainRow ">
                            <?= $address->name ?>
                        </div>
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--iconic dataList-cell--alt dataList-cell--action">
                    <a href="<?= $app->buildLink('Pub:address/delete', $address) ?>" class="iconic iconic--delete dataList-delete"
                       data-overley="true">
                        <i aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td class="dataList-cell dataList-cell--main dataList-cell-error">
                <?= \Base\BaseApp::phrase('there_are_no_categories_created') ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>