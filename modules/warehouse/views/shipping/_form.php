<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Shipping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shipping-form col-lg-4">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shipping_type')->textInput() ?>

    <?= $form->field($model, 'provider_warehouse_id')->textInput() ?>

    <?= $form->field($model, 'supplier_warehouse_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
