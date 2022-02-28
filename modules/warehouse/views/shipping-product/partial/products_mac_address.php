<?php

use kartik\select2\Select2;

?>

<div class="select-mac-address">
    <?= '<label class="control-label">MAC հասցե</label>' ?>

    <?= Select2::widget([
        'name' => 'ShippingProduct[product_id][]',
        'theme' => Select2::THEME_KRAJEE,
        'maintainOrder' => true,
        'options' => [
                'class' => 'form-group sk-floating-label mac-address-select',
            'id' => 'mac-address-id',
            'placeholder' => Yii::t('app', 'Ընտրել'),
            'disabled' => true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'multiple' => true,
        ],
    ])
    ?>

</div>

