<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qty-type-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-lg-4">
        <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
    </div>
    <div style="padding-left: 15px;">
        <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
