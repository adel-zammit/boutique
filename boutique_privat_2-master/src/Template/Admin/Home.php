<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('home') ?> - <?= \Base\BaseApp::getConfigOptions()->defaultNameSite ?>
        </h1>
    </div>
</div>

<table class="dataList-table">
    <tbody>
    <tr>
        <td class="dataList-cell dataList-cell--main">
            <a href="<?= $app->buildLink('admin:user') ?>">
                <div class="dataList-mainRow">
                    <i class="fas fa-users"></i> <?= \Base\BaseApp::phrase('user_list') ?>
                </div>
            </a>
        </td>
    </tr>
    <tr>
        <td class="dataList-cell dataList-cell--main">
            <a href="<?= $app->buildLink('admin:category') ?>">
                <div class="dataList-mainRow">
                    <i class="far fa-cubes"></i> <?= \Base\BaseApp::phrase('category') ?>
                </div>
            </a>
        </td>
    </tr>
    </tbody>
</table>