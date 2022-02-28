<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationProducts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complectation-products-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'n_product_count')->textInput() ?>

    <?= $form->field($model, 'complectation_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
