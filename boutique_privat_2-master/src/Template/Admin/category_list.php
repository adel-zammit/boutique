<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('categories_list') ?>
        </h1>
        <div class="p-title-pageAction">
            <a href="<?= $app->buildLink('admin:category/add') ?>"
               class="button button--icon button--icon--add"><span
                        class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'category']) ?></span></a>
        </div>
    </div>
</div>

<table class="dataList-table">
    <tbody>
    <?php if($params->categoryTree) { ?>
        <?php foreach ($params->categoryTree as $entryTree) {?>
            <tr>
                <td class="dataList-cell dataList-cell--min dataList-cell--link">
                    <a href="<?= $app->buildLink('admin:category/edit', $entryTree) ?>">
                        <img src="<?= $entryTree->getUrlLogo() ?> " alt="<?= $entryTree->name ?>">
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--main">
                    <a href="<?= $app->buildLink('admin:category/edit', $entryTree) ?>">
                        <div class="dataList-mainRow u-depth<?= $entryTree->depth ?>">
                            <?= $entryTree->name ?>
                        </div>
                    </a>
                </td>
                <td class="dataList-cell dataList-cell--iconic dataList-cell--alt dataList-cell--action">
                    <a href="<?= $app->buildLink('admin:category/delete', $entryTree) ?>" class="iconic iconic--delete dataList-delete"
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