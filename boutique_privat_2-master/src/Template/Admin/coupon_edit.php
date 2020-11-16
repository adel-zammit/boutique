<div class="p-main-header">
    <div class="p-title ">
        <h1 class="p-title-value">
            <?php if($params->coupon->isInsert()) { ?>
                <?= \Base\BaseApp::phrase('add_type', ['type' => strtolower(\Base\BaseApp::phrase('coupon'))]) ?>
            <?php } else {?>
                <?= \Base\BaseApp::phrase('edit_type:', ['type' => strtolower(\Base\BaseApp::phrase('coupon'))]) . ' ' . $params->coupon->title ?>
            <?php }?>
        </h1>
    </div>
</div>
<div class="block-formRow block-form">
    <div class="block-form-inner">
        <form action="<?= $app->buildLink('admin:coupon/save', $params->coupon) ?>"  method="post" class="form-submit-ajax">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="title"><?=  \Base\BaseApp::phrase('title:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input type="text" value="<?= $params->coupon->title ?>" id="title" class="input" name="title">
                </dd>
            </dl>
            <hr class="hr-form">
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="code"><?=  \Base\BaseApp::phrase('code:') ?></label>
                    </div>
                </dt>
                <dd>
                    <input type="text" value="<?= $params->coupon->code ?>" id="code" class="input" name="code">
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="code"><?=  \Base\BaseApp::phrase('coupon_type:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?= $form->getRadio($params->coupon->coupon_type, 'coupon_type', [
                        'percent' => [
                            'value' => 'percent',
                            'name' => 'percent',
                            'input' => [
                                'percent_value' => [
                                    'type' => 'number',
                                    'value' => $params->coupon->coupon_type == 'percent' ? $params->coupon->value : 0,
                                    'required' => false,
                                    'step' => 0.01,
                                    'min' => 0,
                                    'max' => '',
                                    'otherText' => '<span class="text-input">%</span>'
                                ],
                            ],
                        ],
                        'value' => [
                            'value' => 'value',
                            'name' => 'flat',
                            'input' => [
                                'flat_value' => [
                                    'type' => 'number',
                                    'value' => $params->coupon->coupon_type == 'value' ? $params->coupon->value : 0,
                                    'required' => false,
                                    'step' => 0.01,
                                    'min' => 0,
                                    'max' => '',
                                    'otherText' => '<span class="text-input">EUR</span>'
                                ],
                            ],
                        ]
                    ]) ?>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="code"><?=  \Base\BaseApp::phrase('valid_from:') ?></label>
                    </div>
                </dt>
                <dd>
                    <div class="inputGroup">
                        <div class="inputGroup inputGroup--date inputGroup--joined inputDate">
                            <input type="text" id="datepicker"
                                   value="<?= date('Y-m-d', $params->coupon->start_date) ?>"
                                   class="input datepicker"
                                   name="start_date">
                            <span class="inputGroup-text inputDate-icon js-dateTrigger"></span>
                        </div>
                        <span class="inputGroup-splitter"></span>
                        <input type="time" class="input" name="start_time" value="<?= date('H:i', $params->coupon->start_date) ?>">
                    </div>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="code"><?=  \Base\BaseApp::phrase('valid_for:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?php if($params->coupon->isInsert()) {?>
                        <div class="inputGroup">
                            <?= $form->getInputNumber('length_amount', 7, false, 1, 0) ?>
                            <span class="inputGroup-splitter"></span>
                            <select name="length_unit" class="input input--inline">
                                <option value="day"><?= \Base\BaseApp::phrase('days') ?></option>
                                <option value="month"><?= \Base\BaseApp::phrase('months') ?></option>
                                <option value="year"><?= \Base\BaseApp::phrase('years') ?></option>
                            </select>
                        </div>
                    <?php } else { ?>
                        <div class="inputGroup">
                            <div class="inputGroup inputGroup--date inputGroup--joined inputDate">
                                <input type="text" id="datepicker"
                                       value="<?= date('Y-m-d', $params->coupon->end_date) ?>"
                                       class="input datepicker"
                                       name="length_amount_update">
                                <span class="inputGroup-text inputDate-icon js-dateTrigger"></span>
                            </div>
                            <span class="inputGroup-splitter"></span>
                            <input type="time" class="input" name="length_unit_update" value="<?= date('H:i', $params->coupon->end_date) ?>">
                        </div>
                    <?php }?>
                </dd>
            </dl>
            <dl class="formRow">
                <dt>
                    <div class="block-form-label">
                        <label for="code"><?=  \Base\BaseApp::phrase('from:') ?></label>
                    </div>
                </dt>
                <dd>
                    <?= $form->getInputNumber('coupon_min', $params->coupon->coupon_min, false, 0.01, 0) ?>
                </dd>
            </dl>
            <div class="p-submit">
                <button type="submit" name="submit" value="1" class="button"><i class="fas fa-save fa-space-1x"></i> <?=  \Base\BaseApp::phrase('save') ?></button>
            </div>
        </form>
    </div>
</div>
<script>
    var picker = [];

    $.each($('.inputDate'), function (key) {
        picker[key] = new Pikaday({
            field: $(this).find('.datepicker')[0],
            trigger: $(this)[0],
            format: 'D-M-YYYY',
            toString(date, format) {console.log(date)
                const day = ("0" + (date.getDate())).slice(-2);
                const month = ("0" + (date.getMonth() + 1)).slice(-2);
                const year = date.getFullYear();
                return `${year}-${month}-${day}`;
            },
        });
    })
</script>