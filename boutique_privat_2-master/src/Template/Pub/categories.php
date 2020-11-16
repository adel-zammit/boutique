<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= \Base\BaseApp::phrase('categories_list') ?>
        </h1>
    </div>
</div>
<div class="categories-list">
    <?php
    /** @var \App\Entity\Categories $category */
    foreach ($params->categoryTree->categoryByDepth()  as $category) {
        $output = [];
        $child = $params->categoryTree->treeCategory([$category], $output, 1);
        ?>
        <div class="block-with-border">
            <div class="category" data-category-id="<?= $category->category_id ?>" >
                <div class="category-inner category-img">
                    <img src="<?= $app->getBaseLink() ?><?= $category->getUrlLogo() ?>" alt="<?= $category->name ?>">
                </div>
                <div class="category-inner category-title">
                    <a href="<?= $app->buildLink('Pub:product/categories', $category) ?>">
                        <?= $category->name ?>
                    </a>
                </div>
                <?php if($child) {?>
                    <div class="category-action">
                        <i class="fas fa-plus"></i>
                    </div>
                <?php } ?>
            </div>
            <div class="child-category">
                <?php
                foreach ($child as $childCategory ) {?>
                    <div class="category child-category-content">
                        <div class="category-inner category-title">
                            <a href="<?= $app->buildLink('Pub:product/categories', $childCategory) ?>">
                                <?= $childCategory->name ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>
<script>
   $('.category-action').click(function () {
        var parent = $(this).closest('.block-with-border');
        var child = parent.find('.child-category');
        if(child.hasClass('child-active'))
        {
            child.removeClass('child-active');
            parent.find('.child-category').stop(true,true).slideUp();;
        }
        else
        {
            child.addClass('child-active');
            parent.find('.child-category').stop(true,true).slideDown();
        }

   })
</script>
