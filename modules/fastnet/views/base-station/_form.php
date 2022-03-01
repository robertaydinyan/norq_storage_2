<?php

use app\modules\fastnet\models\BaseStation;
use app\modules\fastnet\models\Zone;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\BaseStation */
/* @var $equipments app\modules\fastnet\models\BazeStationEquipments */
/* @var $form yii\widgets\ActiveForm */

//varDumper($model->selectedZone());
?>
<style>
    .select2-container--krajee, .select2-selection__rendered {
        height: 38px !important;
    }
    .select2-selection__clear {
        line-height: 38px !important;
    }
    .select2-selection {
        height: 36px !important;
    }
</style>
<div class="base-station-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-row">
        <?= $form->field($model, 'name',[
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ip',[
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ip_end',[
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?php
        if (!$model->isNewRecord) {
            $model->zona_id = $model->selectedZone();
        }
        ?>
        <?= $form->field($model, 'zona_id', [
            'template' => '{label}{input}{error}{hint}',
            'options' => ['class' => 'form-group col-md-4'],
        ])->widget(Select2::className(), [
            'theme' => Select2::THEME_KRAJEE,
            'data' => ArrayHelper::map(Zone::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
            'maintainOrder' => true,
            'pluginOptions' => [
                'multiple' => true,
                'allowClear' => true,
            ],
        ])->label('Գոտի') ?>

        <?php if($model->isNewRecord){ $isset_equipments = [];} ?>

        <?= $form->field($equipments, 'equipment_id', [
            'template' => '{label}{input}{error}{hint}',
            'options' => ['class' => 'form-group col-md-4'],
        ])->widget(Select2::className(), [
            'theme' => Select2::THEME_KRAJEE,
            'data' => BaseStation::Equipments,
            'maintainOrder' => true,

            'options' => [
                'placeholder' => Yii::t('app', 'Ընտրել'),
                'value'=>$isset_equipments,
                'multiple'=>true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Սարքավորումներ') ?>

        <?php if (!$model->isNewRecord) : ?>
            <div class="form-group col-md-4">
                <label class="control-label" for="basestation-ip">Ջնջել հին Ip-ները՞</label>
                <input type="checkbox" name="delete_olds" value="1" checked autocomplete="off">
            </div>
        <?php endif; ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Ստեղծել', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
