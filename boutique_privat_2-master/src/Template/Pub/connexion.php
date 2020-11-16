
<?= $error->getMessage() ?>
<div class="block-form forum-connexion">
    <div class="block-form-inner">
        <h1><?=  \Base\BaseApp::phrase('connexion') ?></h1>
        <form action="<?= $app->buildLink('Pub:login/login', NULL, ['redirect' =>\Base\BaseApp::filter('redirect', 'str')]) ?>" method="post" class="form-submit-ajax">
            <div class="p-form">
                <label for="login"><?=  \Base\BaseApp::phrase('username') ?></label>
                <input type="text" name="login" class="input" placeholder="<?=  \Base\BaseApp::phrase('username') ?>" required="required" id="login">
            </div>
            <div class="p-form">
                <label for="password"><?=  \Base\BaseApp::phrase('password') ?></label>
                <input type="password" name="password" class="input" placeholder="<?=  \Base\BaseApp::phrase('password') ?>" required="required" id="password">
            </div>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-sign-in fa-space-1x"></i>
                    <?=  \Base\BaseApp::phrase('connexion') ?></button>
            </div>
        </form>
        <div class="more-info-form">
            <div  class="more-info-form-text">
                Vous n'avez pas de compte?
            </div>
            <a href="<?= $app->buildLink('Pub:login/register') ?>" class="button">
                <span class="button-text">
                    S'inscrire maintenant
                </span>
            </a>
        </div>
    </div>
</div>