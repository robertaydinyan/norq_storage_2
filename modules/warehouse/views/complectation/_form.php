<?php

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */
/* @var $model_products app\modules\warehouse\models\ComplectationProducts */
/* @var $dataWarehouses app\modules\warehouse\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/modules/warehouse/complectation.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/shipping_new.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="complectation-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-6">
            <label class="control-label"   for="namiclature_id"><?php echo Yii::t('app', 'Nomenclature'); ?></label>
            <div id="showProducts"></div>
           <input type="text" class="form-control"   onfocus="selectProductNamiclature($(this))" required="required"><br>
           <input type="hidden" name="namiclature_id" class="namiclature_id">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'count')->input('number') ?>
            <?= $form->field($model, 'created_at')->textInput(['class'=>'datepicker form-control']) ?>
            <?= $form->field($model, 'warehouse_id', [
                'options' => ['class' => 'form-group provider_warehouse'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => $dataWarehouses,
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Select'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'disabled' => !$model->isNewRecord
                ],
            ]) ?>
        </div>
        <div class="shipping-request-form col-sm-6">
            <?php if($model->isNewRecord){ ?>
                <div class="hide-block"></div>
                <div id="deal-addresses"  class="module-service-form-card border-primary position-relative col-md-12 mt-3">
                    <div class="row product-block" >
                         <div class="col-sm-4">
                            <?= $form->field($model_products, 'product_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label nm_products'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => $nProducts,
                                'maintainOrder' => true,
                                'options' => [
                                    'id' => 'nomenclature_product',
                                    'class'=>'nm_products',
                                    'placeholder' => Yii::t('app', 'Select')
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group counts-input sk-floating-label field-shippingrequest-count">
                                <select name="ComplectationProducts[product_id][]" class="ns_products form-control" required="required" >
                                    <option value=""></option>
                                </select>
                             <label class="control-label" for="shippingrequest-count"><?php echo Yii::t('app', 'good') ?></label><div class="help-block"></div>
                            </div>            
                        </div>
                       
                 
                        <div class="col-sm-3">
                            <?= $form->field($model_products, 'n_product_count[]', [
                                'options' => ['class' => 'form-group counts-input sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true,'type' => 'number','required'=>'required']) ?>
                        </div>
                      
                    </div>
                    <div class="add-address">
                        <span class="btn-add-product"><?php echo Yii::t('app', 'Add');?></span>
                    </div>
                </div>
            <?php }  ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary check-counts']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
