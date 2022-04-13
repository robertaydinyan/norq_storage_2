<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\WarehouseTypes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="warehouse-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_hy')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>