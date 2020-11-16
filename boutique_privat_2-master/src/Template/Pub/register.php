<?= $error->getMessage() ?>
<div class="block-form forum-connexion">
    <div class="block-form-inner">
        <h1><?=  \Base\BaseApp::phrase('registration') ?></h1>
        <form action="<?= $app->buildLink('Pub:login/register') ?>" method="post">
            <div class="p-form">
                <label for="username"><?=  \Base\BaseApp::phrase('username') ?></label>
                <input type="text" name="username" class="input" placeholder="<?=  \Base\BaseApp::phrase('Username') ?>" required="required" id="username">
            </div>
            <div class="p-form">
                <label for="password"><?=  \Base\BaseApp::phrase('password') ?></label>
                <input type="password" name="password" class="input" placeholder="<?=  \Base\BaseApp::phrase('password') ?>" required="required" id="password">
            </div>
            <div class="p-form">
                <label for="confPassword"><?=  \Base\BaseApp::phrase('type_password', ['type' => 'Confirmation']) ?></label>
                <input type="password" name="confPassword" class="input" placeholder="<?=  \Base\BaseApp::phrase('type_password', ['type' => 'Confirmation']) ?>" required="required" id="confPassword">
            </div>
            <div class="p-form">
                <label for="email"><?=  \Base\BaseApp::phrase('email') ?></label>
                <input type="email" name="email" class="input" placeholder="<?=  \Base\BaseApp::phrase('email') ?>" required="required" id="email">
            </div>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-key fa-space-1x"></i> <?=  \Base\BaseApp::phrase('registration') ?></button>
            </div>
        </form>
    </div>
</div>