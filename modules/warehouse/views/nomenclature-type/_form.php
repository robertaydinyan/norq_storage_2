<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureType */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>

<div class="nomenclature-type-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group col-3">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
