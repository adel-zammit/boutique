<?= $error->getMessage() ?>
<div class="block-form forum-connexion">
    <div class="block-form-inner">
        <h1><?=  \Base\BaseApp::phrase('connexion') ?></h1>
        <form action="<?= $app->buildLink('admin:connexion') ?>" method="post" class="form-submit-ajax">
            <div class="p-form">
                <label for="username"><?=  \Base\BaseApp::phrase('username') ?></label>
                <input type="text" name="username" class="input" placeholder="<?=  \Base\BaseApp::phrase('Username') ?>" required="required" id="username">
            </div>
            <div class="p-form">
                <label for="password"><?=  \Base\BaseApp::phrase('password') ?></label>
                <input type="password" name="password" class="input" placeholder="<?=  \Base\BaseApp::phrase('password') ?>" required="required" id="password">
            </div>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-sign-in fa-space-1x"></i> <?=  \Base\BaseApp::phrase('connexion') ?></button>
            </div>
        </form>
    </div>
</div>