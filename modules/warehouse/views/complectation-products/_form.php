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
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
