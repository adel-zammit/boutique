<script type="text/javascript" src="styles/js/spectrum.js"></script>
<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?= $params->title ?>
        </h1>
    </div>
</div>

<?php
$value = $params->formParam;
$formInput = $params->formRepo;
$ajax = isset($value->ajax) && $value->ajax ? 'form-submit-ajax' : '';
?>
<div class="block-form">
    <div class="block-miner">
        <form action="<?= $value->saveURL ?>" method="post"  enctype="multipart/form-data" class="<?= $ajax ?> form-submit-action">
            <?php foreach ($value->Input as $name => $valueInput){ ?>
                <?php if($valueInput['type'] !== 'hidden') {?>
                    <div class="p-form">
                        <label class="form-label" > <?= $valueInput['title'] ?> :</label>
                            <?php
                            switch ($valueInput['type'])
                            {
                                case 'spinbox' :
                                    echo $formInput->getInputNumber($name, $valueInput['value'], $valueInput['required'], $valueInput['step'], $valueInput['min'], $valueInput['max']);
                                    break;
                                case 'textbox' :
                                    echo $formInput->getTextBox($name, $valueInput['value']);
                                    break;
                                case 'selector' :
                                    echo $formInput->getSelector($name, $valueInput);
                                    break;
                                case 'textarea' :
                                    echo $formInput->getTextarea($name, $valueInput);
                                    break;
                                case 'radio' :
                                    echo $formInput->getRadio($valueInput['value'], $name, $valueInput['InputValue']);
                                    break;
                                case 'editor' :
                                    echo $formInput->getEditor($name, $valueInput['value']);
                                    ?>
                                    <script>
                                        var editorCreator = new editor();
                                        editorCreator.run();
                                    </script>
                                    <?php
                                    break;
                            }
                            ?>
                            <div class="form-explain">
                                <?= $valueInput['description'] ?>
                            </div>
                    </div>
                <?php } else { ?>

                    <?= $formInput->getHidden($valueInput['value'], $name); ?>
                <?php } ?>
            <?php } ?>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="<?= $value->logoButton ?>"></i> <?= $value->nameButton ?> </button>
             </div>
        </form>
    </div>
</div>
