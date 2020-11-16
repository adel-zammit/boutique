<div class="footer-conteneur">
    <ul>
        <li>
            <a href="<?= $app->buildLink('Pub:'); ?>">
                <i class="far fa-home fa-5x"></i>
            </a>
        </li>
        <?php if(!isset($_SESSION['user_id'])) { ?>
            <li>
                <a href="<?= $app->buildLink('Pub:login'); ?>">
                    <i class="far fa-sign-in-alt fa-5x"></i>
                </a>
            </li>
            <li>
                <a href="<?= $app->buildLink('Pub:login/register'); ?>">
                    <i class="far fa-key fa-5x"></i>
                </a>
            </li>
        <?php } else { ?>
            <li>
                <a href="<?= $app->buildLink('Pub:profile'); ?>">
                    <i class="far fa-user fa-5x"></i>
                </a>
            </li>
            <li>
                <a href="<?= $app->buildLink('Pub:login/logout'); ?>">
                    <i class="far fa-sign-out-alt fa-5x"></i>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>