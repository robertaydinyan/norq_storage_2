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
    </div>

    <?php ActiveForm::end(); ?>

</div>
