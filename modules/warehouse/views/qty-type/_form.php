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
        <?= $form->field($model, 'type_hy')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'type_ru')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'type_en')->textInput(['maxlength' => true]) ?>
    </div>
    <div style="padding-left: 15px;">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>