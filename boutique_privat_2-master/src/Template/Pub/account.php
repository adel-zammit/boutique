<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('account') ?>
        </h1>
    </div>
</div>
<?php $user = \Base\BaseApp::visitor(); ?>
<div class="block-tab">
    <ul>
        <li data-tab-id="tab-default-info" data-current-active="true">
            Information de base
        </li>
        <li data-tab-id="tab-default-password" data-current-active="false">
            Password
        </li>
        <a href="<?= $app->buildLink('Pub:address') ?>">
            <li>
                <?=  \Base\BaseApp::phrase('address') ?>
            </li>
        </a>
        <a href="<?= $app->buildLink('Pub:invoices') ?>#tab-default-password">
            <li>
                <?=  \Base\BaseApp::phrase('invoices') ?>
            </li>
        </a>
    </ul>
</div>
<div class="block-tab-content">
    <div class="block-tab-style" id="tab-default-info">
        <div class="block-form">
            <div class="block-form-inner">
                <form action="<?= $app->buildLink('Pub:account/save') ?>" method="post" class="form-submit-ajax" >
                    <div class="p-form">
                        <label for="username"><?=  \Base\BaseApp::phrase('username') ?></label>
                        <input type="text" name="username" class="input" placeholder="<?=  \Base\BaseApp::phrase('username') ?>" id="username" value="<?= $user->username ?>">
                    </div>
                    <div class="p-form">
                        <label for="email"><?=  \Base\BaseApp::phrase('email') ?></label>
                        <input type="email" name="email" class="input" placeholder="<?=  \Base\BaseApp::phrase('email') ?>" required="required" id="email" value="<?= $user->email ?>">
                    </div>
                    <div class="p-submit">
                        <button type="submit" name="submit" value="1" class="button"><i class="fas fa-save fa-space-1x"></i> <?=  \Base\BaseApp::phrase('save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="block-tab-style" id="tab-default-password">
        <div class="block-form">
            <div class="block-form-inner">
                <form action="<?= $app->buildLink('Pub:account/password/save') ?>" method="post" class="form-submit-ajax" >
                    <div class="p-form">
                        <label for="password"><?=  \Base\BaseApp::phrase('password') ?></label>
                        <input type="password" name="password" class="input" placeholder="<?=  \Base\BaseApp::phrase('password') ?>" required="required" id="password">
                    </div>
                    <div class="p-form">
                        <label for="confPassword"><?=  \Base\BaseApp::phrase('type_password', ['type' => 'Confirmation']) ?></label>
                        <input type="password" name="confPassword" class="input" placeholder="<?=  \Base\BaseApp::phrase('type_password', ['type' => 'Confirmation']) ?>" required="required" id="confPassword">
                    </div>
                    <div class="p-form">
                        <label for="oldPassword"><?=  \Base\BaseApp::phrase('type_password', ['type' => 'Ancien']) ?></label>
                        <input type="password" name="oldPassword" class="input" placeholder="<?=  \Base\BaseApp::phrase('type_password', ['type' => 'Ancien']) ?>" required="required" id="oldPassword">
                    </div>
                    <div class="p-submit">
                        <button type="submit" name="submit" value="1" class="button"><i class="fas fa-save fa-space-1x"></i> <?=  \Base\BaseApp::phrase('save') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>