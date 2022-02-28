<?php

use app\modules\warehouse\models\NomenclatureProduct;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $shippingProductsRequest yii\data\ActiveDataProvider */
/* @var $shippingId yii\data\ActiveDataProvider */
/* @var $model yii\data\ActiveDataProvider */
/* @var $nProducts yii\data\ActiveDataProvider */
?>
<div class="request-update-update">

    <h1>Հարցման փոփոխում</h1>

    <?php $form = ActiveForm::begin(); ?>


    <?php foreach ($shippingProductsRequest as $shippingProductRequest) : ?>
        <div class="row deal-address-block" >

            <div class="col-sm-12">
                <?= $form->field($model, 'id[]', [
                    'options' => ['class' => 'form-group sk-floating-label'],
                    'template' => '{input}{error}{hint}',
                ])->textInput(['maxlength' => true , 'type' => 'hidden',  'value' => $shippingProductRequest['id'] ?: '']) ?>
            </div>

            <div class="col-lg-12" style="display: flex">
                <div class="col-sm-5">
                    <?= $form->field(\app\modules\warehouse\models\ShippingRequest::findOne($shippingProductRequest['id']), 'nomenclature_product_id', [
                        'template' => '{input}{label}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => $nProducts,
                        'maintainOrder' => true,
                        'options' => [
                            'name' => 'ShippingRequest[nomenclature_product_id][]',
                            'class' => 'country-select',
                            'id' => 'nomenclature_product-select'.$shippingProductRequest['id'],
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'count[]', [
                        'options' => ['class' => 'form-group sk-floating-label'],
                        'template' => '{input}{label}{error}{hint}',
                    ])->textInput(['maxlength' => true, 'value' => $shippingProductRequest['count'] ?: ''])->label("Քանակ") ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="remove-address d-none float-right">
                    <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Ջնջել') ?></span>
                </div>
            </div>

        </div>

    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
