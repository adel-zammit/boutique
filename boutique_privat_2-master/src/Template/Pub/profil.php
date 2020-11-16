<div class="p-main-header">
    <div class="p-title">
        <h1 class="p-title-value">
            <?= Base\BaseApp::phrase('profil') ?>
        </h1>
    </div>
</div>

<?= $error->getMessage() ?>

<div class="content-account">
    <div class="block">
        <div class="block-form">
            <form action="<?= $app->buildLink('Pub:profile') ?>" method="post">
                <div class="p-form first">
                    <label class="form-label" for="login"><?= Base\BaseApp::phrase('username') ?></label>
                    <input type="text" name="login" value="<?= $params->user->login ?>" maxlength="255" id="login"
                           class="input">
                </div>
                <div class="p-form">
                    <label class="form-label" for="email"><?= Base\BaseApp::phrase('email') ?></label>
                    <input type="email" id="email" name="email" maxlength="255" class="input" value="<?= $params->user->email ?>">
                </div>
                <div class="p-form">
                    <label class="form-label" for="old_password"> <?= Base\BaseApp::phrase('type_password', ['type' => 'Old']) ?></label>
                    <input type="password" id="old_password" name="old_password" maxlength="255" required="required"
                           class="input">
                </div>
                <div class="p-form">
                    <label class="form-label" for="password"> <?= Base\BaseApp::phrase('type_password', ['type' => 'New']) ?></label>
                    <input type="password" id="password" name="password" maxlength="255" class="input">
                </div>
                <div class="p-form">
                    <label class="form-label" for="conf_password"><?= Base\BaseApp::phrase('type_password', ['type' => 'Confirmation New']) ?></label>
                    <input type="password" id="conf_password" name="conf_password" class="input">
                </div>
                <div class="p-submit">
                    <button type="submit" class="button"><i class="far fa-save"></i> <?= Base\BaseApp::phrase('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>