<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complectation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'new_product_price') ?>

    <?= $form->field($model, 'service_fee') ?>

    <?= $form->field($model, 'new_product_count') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'nomenclature_product_id') ?>

    <?php // echo $form->field($model, 'provider_warehouse_id') ?>

    <?php // echo $form->field($model, 'supplier_warehouse_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
