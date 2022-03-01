<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItemModel */
?>
<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">
        <?php echo $form->field($model, 'name', [
            'options' => ['class' => 'form-group col-md-6']
        ])->textInput(['maxlength' => 64]); ?>

        <?php echo $form->field($model, 'ruleName', [
            'options' => ['class' => 'form-group col-md-6']
        ])->widget('yii\jui\AutoComplete', [
            'options' => [
                'class' => 'form-control',
            ],
            'clientOptions' => [
                'source' => array_keys(Yii::$app->authManager->getRules()),
            ],
        ]);
        ?>

        <?php echo $form->field($model, 'description', [
            'options' => ['class' => 'form-group col-md-6']
        ])->textarea(['rows' => 2]); ?>

        <?php echo $form->field($model, 'data', [
            'options' => ['class' => 'form-group col-md-6']
        ])->textarea(['rows' => 6]); ?>
    </div>

    <div class="form-group">
        <?php echo Html::submitButton($model->getIsNewRecord() ? Yii::t('app', 'Ստեղծել') : Yii::t('app', 'Թարմացնել'), ['class' => $model->getIsNewRecord() ? 'btn btn-primary' : 'btn btn-primary']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
