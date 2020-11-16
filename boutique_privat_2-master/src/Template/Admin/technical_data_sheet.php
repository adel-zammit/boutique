<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
           teet
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:category/technical-data-sheet/add') ?>"
               class="button button--icon button--icon--add" data-overley-form="true"><span
                    class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'Fiche téchnique']) ?></span></a>
        </div>
    </div>
</div>

<table class="dataList-table">
    <?php if(!empty($params->infos)) {?>
        <?php
        foreach ($params->infos as $info) {?>
            <tbody class="dataList-rowGroup">
            <tr class="dataList-row dataList-row--noHover dataList-row--subSection" >
                <td class="dataList-cell" colspan="2">
                    <div class="dataList-mainRow u-depth<?= $info['category']->depth ?>">
                        <?= $info['category']->name ?>
                    </div>
                </td>
            </tr>
            <?php if($info)
            {
                foreach ($info['find'] as $t)
                { ?>
                    <tr class="dataList-row dataList-sous-cat">
                        <td class="dataList-cell dataList-cell--main ">
                            <a href="<?= $app->buildLink('admin:category/technical-data-sheet/edit', $t) ?>" data-overley-form="true">
                                <div class="dataList-mainRow u-depth<?= $info['category']->depth ?>">
                                    <?= $t->title ?>
                                </div>
                            </a>
                        </td>
                        <td class="dataList-cell dataList-cell--iconic dataList-cell--alt dataList-cell--action">
                            <a href="<?= $app->buildLink('admin:category/technical-data-sheet/deleted', $t) ?>" class="iconic iconic--delete dataList-delete"
                               data-overley="true">
                                <i aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr class="dataList-row dataList-row--noHover dataList-row--note">
                    <td class="dataList-cell dataList-cell--noSearch" colspan="4">
                        No questions have been added to this category yet.
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        <?php } ?>
    <?php } ?>
</table>
