<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
           product
        </h1>
    </div>
</div>
<div class="block-formRow block-form">
    <div class="block-form-inner">
        <form action="<?= $app->buildLink('admin:product/save',  $params->product, ['category_id' => $params->category->category_id]) ?>" method="post" class="form-submit-ajax form-submit-action" enctype="multipart/form-data">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('title:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input type="text"
                           name="title"
                           class="input"
                           id="title" value="<?= $params->product->title ?>">
                </dd>
            </dl>
            <dl class="formRow formRow-noLabel">
                <dd>
                    <div class="base-style-editor editor2">
                        <div class="button-editor">
                        </div>
                        <div class="fr-editor-write" dir="ltr" style="max-height: 930px; overflow: auto;">
                            <div class="editor-write" dir="ltr" contenteditable="true" style="min-height: 100px;"
                                 aria-disabled="false" spellcheck="true">
                                <?= \Base\Util\MessageBbCode::parser($params->product->description, true) ?>
                            </div>
                        </div>
                        <textarea id="editor" name="description" minlength="10" class="input"
                                  rows="5">
                        <?= \Base\Util\MessageBbCode::parser($params->product->description, true) ?>
                    </textarea>
                    </div>
                    <script>
                        var editor3 = new editor();
                        editor3.setClassName('editor2');
                        editor3.run();
                    </script>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('upload_img_default:') ?></label>
                    </div>
                </dt>
                <dd>
                    <div class="inputGroup input-file">
                        <?= \Base\Util\Img::getImg($params->product, 'icon_date', 'defaultProduct', 'default_img_product', 'm') ?>
                        <span class="inputGroup-splitter"></span>
                        <div class="input-group-content">
                            <input  name="file"
                                    type="file"
                                    data-type-count="false"
                                    class="input"
                                    value="<?= $params->product->getUrlBypath() ?>">
                        </div>
                    </div>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('price:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?= $form->getInputNumber('price', $params->product->price , true, 0.01, 0) ?>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('stock:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?= $form->getInputNumber('stock', $params->product->stock , true, 1, 0) ?>
                </dd>
            </dl>
            <?php if($params->product->isInsert()) { ?>
                <?php foreach ($params->technicalDataSheet as $technical) {?>
                    <dl class="formRow">
                        <dt>
                            <div class="block-form-label">
                                <label><?= $technical->title ?>:</label>
                            </div>
                        </dt>
                        <dd>
                            <div class="base-style-editor editor">
                                <div class="button-editor">
                                </div>
                                <div class="fr-editor-write" dir="ltr" style="max-height: 930px; overflow: auto;">
                                    <div class="editor-write" dir="ltr" contenteditable="true" style="min-height: 100px;"
                                         aria-disabled="false" spellcheck="true">
                                    </div>
                                </div>
                                <textarea id="editor" name="technical[<?= $technical->technical_data_sheet_id ?>]" minlength="10" class="input"
                                          rows="5">
                                </textarea>
                            </div>
                        </dd>
                    </dl>
                <?php } ?>
            <?php } else { ?>
                <?php foreach ($params->product->TechnicalDataSheetValues as $technical) {?>
                    <dl class="formRow">
                        <dt>
                            <div class="block-form-label">
                                <label><?=  $technical->TechnicalDataSheet->title ?>:</label>
                            </div>
                        </dt>
                        <dd>
                            <div class="base-style-editor editor">
                                <div class="button-editor">
                                </div>
                                <div class="fr-editor-write" dir="ltr" style="max-height: 930px; overflow: auto;">
                                    <div class="editor-write" dir="ltr" contenteditable="true" style="min-height: 100px;"
                                         aria-disabled="false" spellcheck="true">
                                        <?= \Base\Util\MessageBbCode::parser($technical->value, true) ?>
                                    </div>
                                </div>
                                <textarea id="editor" name="technical[<?= $technical->value_id ?>]" minlength="10" class="input"
                                          rows="5">
                                <?= \Base\Util\MessageBbCode::parser($technical->value, true) ?>
                            </textarea>
                            </div>
                        </dd>
                    </dl>
                <?php } ?>
            <?php } ?>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('upload_img:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input  name="files"
                            type="file"
                            class="input"
                            id="changeFile"
                            data-type-count="true"
                            data-link-file="<?= $params->product->isInsert() ? $app->buildLink('admin:product/save-img') : $app->buildLink('admin:product/save-img', $params->product) ?>">
                    <div class="list-product-img">
                        <?php foreach ($params->product->ProductImg as $productImg) {?>
                            <div class="content-img">
                                <div class="content-image-inner">
                                    <img src="<?= $productImg->getUrlLogo() ?>" alt="<?= $productImg->name ?>"></div>
                                <div class="content-image-inner"><?= $productImg->name ?>"</div>
                                <input type="hidden" name="product_img[]" value="<?= $productImg->product_img_id ?>" >
                                <div class="img-action">
                                    <button class="button delete-img" data-delete-img="<?= $app->buildLink('admin:product/delete-img') ?>" data-product-img-id="<?= $productImg->product_img_id ?>">Delete</button>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </dd>
            </dl>

            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-save fa-space-1x"></i> <?=  \Base\BaseApp::phrase('save') ?></button>
            </div>
        </form>
    </div>
</div>
<script>
    var editor2 = new editor(['bold', 'italic']);
    editor2.run();
</script>
