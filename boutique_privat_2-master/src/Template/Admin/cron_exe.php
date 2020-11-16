<div class="p-main-header">
    <div class="p-title">
        <h1 class="p-title-value">
            Cron execute
        </h1>
    </div>
</div>

<div class="block">
    <div class="block-form block-error-method">
        <div class="block-miner">
            <?php if(is_bool($params->error) && $params->error) { ?>
                L'entrée Cron a été exécutée avec succès.
            <?php } else { ?>
                <?= $params->error ?>
            <?php } ?>
        </div>
    </div>
</div>
