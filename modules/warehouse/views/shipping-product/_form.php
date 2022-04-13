<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
/* @var $dataWarehouses app\modules\warehouse\models\ShippingRequest */
/* @var $shippingModel app\modules\warehouse\models\ShippingRequest */
/* @var $modelNProduct app\modules\warehouse\models\ShippingRequest */
/* @var $dataUsers app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\Shipping */
/* @var $searchModel app\modules\warehouse\models\ShippingRequest */
/* @var $dataProvider app\modules\warehouse\models\ShippingRequest */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/modules/warehouse/shipping.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>

<div style="display: flex">
    <div class="shipping-product-form col-lg-4">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($shippingModel, 'shipping_type', [
            'options' => ['class' => 'form-group'],
        ])->widget(Select2::className(), [
            'theme' => Select2::THEME_KRAJEE,
            'data' => \app\modules\warehouse\models\Shipping::getType(),
            'maintainOrder' => true,
            'hideSearch' => true,
            'options' => [
                'placeholder' => Yii::t('app', 'Ընտրել'),
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

        <?= $form->field($shippingModel, 'provider_warehouse_id', [
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

        <?= $form->field($shippingModel, 'supplier_warehouse_id', [
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

        <div class="module-service-form-card border-primary position-relative col-md-12 mt-3">
            <div class="row deal-address-block">
                <div class="col-sm-12 mt-3 n-product">

                    <?= '<label>MAC հասցե</label>' ?>

                    <?= Select2::widget([
                        'name' => 'ShippingProduct[nomenclature_product_id][]',
                        'theme' => Select2::THEME_KRAJEE,
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'form-group sk-floating-label n-product-select',
                            'id' => 'n-product-id',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                            'disabled' => true,
                            'data-url' => Url::to(['shipping-product/get-mac-address-by-warehouse'])
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

        <?= $form->field($shippingModel, 'user_id', [
            'options' => ['class' => 'form-group'],
        ])->widget(Select2::className(), [
            'theme' => Select2::THEME_KRAJEE,
            'data' => $dataUsers,
            'maintainOrder' => true,
            'hideSearch' => true,
            'options' => [
                'placeholder' => Yii::t('app', 'Ընտրել'),
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>


        <div class="form-group">
            <?= Html::submitButton('Ստեղծել', ['class' => 'btn btn-primary']) ?>
            <?php if(isset($type) && $type == 'create'): ?>
                <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
            <?php endif; ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <div class="col-lg-7">
        <?php if($searchModel !== null) :?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'nProductName',
                        'label' => 'Անուն',
                        'value' => function ($model) {
                            return $model->nProduct->name;
                        }
                    ],
                    [
                        'attribute' => 'count',
                        'label' => 'Քանակ',
                        'value' => function ($model) {
                            return $model->count;
                        }
                    ],
                    [
                        'attribute' => 'qty_type',
                        'label' => 'Քանակի տեսակը',
                        'value' => function ($model) {
                            return $model->nProduct->qtyType->type;
                        }
                    ],

                    ['class' => 'yii\grid\ActionColumn'],

                ],
            ]); ?>
        <?php endif; ?>

    </div>

</div>