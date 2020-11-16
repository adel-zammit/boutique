<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('carts_addresses') ?>
        </h1>
    </div>
</div>

<div class="block-form">
    <div class="block-form-inner">
        <form action="<?= $app->buildLink('Pub:carts/address/save') ?>" method="post" class="form-submit-ajax">
            <div class="p-form">
                <label for="addresses"><?=  \Base\BaseApp::phrase('select_addresses') ?></label>
                <select name="address" id="addresses" class="input">
                    <option value=""></option>
                    <?php foreach ($params->addresses as $address) {?>
                        <option value="<?= $address->address_id ?>"> <?= $address->name ?> </option>
                    <?php } ?>
                </select>
            </div>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><?=  \Base\BaseApp::phrase('continue...') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="">
    <a href="<?= $app->buildLink('Pub:address/add', null, ['redirect' => 'carts/address']) ?>"
       class="button button--icon button--icon--add"  data-overley-form="true">
        <span class="button-text"> <?= \Base\BaseApp::phrase('add_type', ['type' => 'address']) ?></span>
    </a>
</div>