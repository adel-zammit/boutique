<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?php if($params->category->isInsert()) {?>
                <?= \Base\BaseApp::phrase('add_type', ['type' => 'category']) ?>
            <?php } else { ?>
                <?= \Base\BaseApp::phrase('edit_type:', ['type' => 'category']) ?> <?= $params->category->name ?>
            <?php } ?>
        </h1>
    </div>
</div>
<div class="block-form">
    <div class="block-form-inner">
        <form action="<?= $app->buildLink('admin:category/save', $params->category) ?>" method="post" class="form-submit-ajax" enctype="multipart/form-data">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="name"><?=  \Base\BaseApp::phrase('name:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input type="text"
                           name="name"
                           class="input"
                           required="required"
                           placeholder="<?=  \Base\BaseApp::phrase('name') ?>"
                           value="<?= $params->category->name ?>"
                           id="name">
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="description"><?=  \Base\BaseApp::phrase('description:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input type="text"
                           name="description"
                           class="input"
                           placeholder="<?=  \Base\BaseApp::phrase('description') ?>"
                           value="<?=  $params->category->description ?>"
                           id="description">
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="logo_category"><?=  \Base\BaseApp::phrase('upload_img:') ?></label>
                    </div>
                </dt>
                <dd>
                    <div class="groupInput inputGroup input-file">
                        <img src="<?= $params->category->getUrlLogo() ?>" alt="<?= $params->category->name ?>">
                        <input type="file"
                               name="logo_category"
                               class="input"
                               placeholder="<?= \Base\BaseApp::phrase('upload_img') ?>"
                               value="<?= $params->category->getUrlLogoBypath() ?>"
                               id="logo_category"
                               accept=".jpeg, .jpg, .png">
                    </div>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="type"><?=  \Base\BaseApp::phrase('category:') ?></label>
                    </div>
                </dt>
                <dd>
                    <select name="category_parent_id" class="input" id="type">
                        <option value="0" <?= !$params->category->parent_category_id ? 'selected' : '' ?>><?= Base\BaseApp::phrase('(none)') ?></option>
                        <?php foreach ($params->treeCategory as $entryTree) {?>
                            <option value="<?= $entryTree['value'] ?>" <?= $params->category->category_parent_id == $entryTree['value'] ? 'selected' : '' ?> > <?= $entryTree['label'] ?></option>
                        <?php } ?>
                    </select>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="type"><?=  \Base\BaseApp::phrase('display_order:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?= $form->getDisplayOrder('display_order', empty($params->category->display_order) ? 0 : $params->category->display_order) ?>
                </dd>
            </dl>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-save fa-space-1x"></i> <?=  \Base\BaseApp::phrase('save') ?></button>
            </div>
        </form>
    </div>
</div>