<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationShipping */
/* @var $complectationModel app\modules\warehouse\models\ComplectationShipping */
/* @var $dataWarehouses app\modules\warehouse\models\ComplectationShipping */
/* @var $dataUsers app\modules\warehouse\models\ComplectationShipping */
/* @var $nProducts app\modules\warehouse\models\ComplectationShipping */
/* @var $nProductsName app\modules\warehouse\models\ComplectationShipping */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/modules/warehouse/shipping.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="complectation-shipping-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">


    <?= $form->field($complectationModel, 'provider_warehouse_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $dataWarehouses,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'class' => 'warehouse-select',
            'id' => 'warehouse_id',
            'placeholder' => Yii::t('app', 'Ընտրել'),
            'data-url' => Url::to(['shipping-product/get-n-product-by-warehouse'])
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($complectationModel, 'supplier_warehouse_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $dataWarehouses,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Ընտրել'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($complectationModel, 'nomenclature_product_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $nProductsName,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Ընտրել'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($complectationModel, 'service_fee')->textInput() ?>

    <?= $form->field($complectationModel, 'new_product_count')->textInput() ?>
        </div>

        <div class="col-lg-6">
    <div class="module-service-form-card border-primary position-relative col-md-12 mt-3">
        <div class="row deal-address-block">
            <div class="col-sm-12 mt-3 n-product">

                <?= '<label>Նոմենկլատուրայի արտադրանք</label>' ?>

                <?= Select2::widget([
                    'name' => 'ComplectationShipping[nomenclature_product_id][]',
                    'theme' => Select2::THEME_KRAJEE,
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'form-group sk-floating-label n-product-select',
                        'id' => 'n-product-id',
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                        'disabled' => true,
                        'data-url' => Url::to(['complectation-shipping/get-mac-address-by-warehouse'])
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ])
                ?>

            </div>
            <div class="col-sm-12 product-nProduct"></div>
            <div class="col-sm-4">
                <div class="remove-address d-none float-right">
                    <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Ջնջել') ?></span>
                </div>
            </div>
        </div>
        <!--        </div>-->

        <div class="add-address">
            <span class="card-action-btn-add-address">Ավելացնել</span>
        </div>

    </div>


        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Ստեղծել ', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


