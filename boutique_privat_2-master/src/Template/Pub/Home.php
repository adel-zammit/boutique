<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('categories_list') ?>
        </h1>
    </div>
</div>

<div class="containe">
<?php foreach($params->reviews as $review) {?>
<?php var_dump($review->Product->title) ?>
<?php } ?>
</div>