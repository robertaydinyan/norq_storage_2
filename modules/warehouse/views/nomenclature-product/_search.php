<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomenclature-product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'vendor_code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'group') ?>

    <?= $form->field($model, 'production_date') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'individual') ?>

    <?php // echo $form->field($model, 'qty_type') ?>

    <?php // echo $form->field($model, 'group_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
