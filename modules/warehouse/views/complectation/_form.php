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
           <input type="text" class="form-control" readonly value="Ծառայություններ"><br>
           <input type="hidden" name="namiclature_id" class="namiclature_id" value="10">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <input type="hidden" value="1"  name="Complectation[count]" autocomplete="off" aria-invalid="false">
            <?= $form->field($model, 'created_at')->textInput(['class'=>'datepicker form-control']) ?>
            <?= $form->field($model, 'other_cost')->input('number') ?>
          
        </div>
        <div class="shipping-request-form col-sm-6">
            <?php if($model->isNewRecord){ ?>
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/shipping-request/create-product.php'); ?>
            <?php }  ?>

        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary check-counts']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<script>
   setTimeout(function(){
      $('.currency__').closest('.field-product-price').remove();
      $('.field-product-nomenclature_product_id').removeClass('col-lg-4');
      $('.field-product-nomenclature_product_id').removeClass('col-xl-4');
      $('.field-product-nomenclature_product_id').addClass('col-lg-8');
      $('.field-product-nomenclature_product_id').addClass('col-xl-8');
   },500);
</script>