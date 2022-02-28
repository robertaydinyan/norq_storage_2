<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
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
    .module-service-form-card{
        margin-bottom: 20px;
    }
</style>

<div class="user-form main-form-wrap">

    <?php $form = ActiveForm::begin(); ?>
        <div class="module-service-form-card">
            <div class="form-row">

                <?= $form->field($model, 'username', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'name', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'last_name', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'email', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'status', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model->getStatus(),
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($model, 'role', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model->getRole(),
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?php
                if (!$model->isNewRecord) {
                    $passwordLabel = 'Գաղտնաբառ - ' . $model->ref_password;
                } else {
                    $passwordLabel = 'Գաղտնաբառ';
                }
                ?>
                <?= $form->field($model, 'password_hash', [
                    'options' => ['class' => 'form-group col-md-6'],
                ])->passwordInput()->label($passwordLabel) ?>

                <?php if ($model->isNewRecord) : ?>
                    <?= $form->field($model, 'password_confirmation', [
                        'options' => ['class' => 'form-group col-md-6'],
                    ])->passwordInput() ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Պահպանել'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
