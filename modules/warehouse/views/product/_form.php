<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use unclead\multipleinput\MultipleInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Product */
/* @var $nProducts app\modules\warehouse\models\Product */
/* @var $physicalWarehouse app\modules\warehouse\models\Product */
/* @var $modelNProduct app\modules\warehouse\models\Product */
/* @var $form yii\widgets\ActiveForm */
/* @var $groupProducts app\modules\warehouse\models\Product */
/* @var $qtyTypes app\modules\warehouse\models\Product */
/* @var $tableTreeGroups app\modules\warehouse\models\Product */

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/createProduct.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
<div class="row product-form">
<div class="col-lg-4">
    <?= $form->field($model, 'nomenclature_product_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $nProducts,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Ընտրել'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
    <?= $form->field($model, 'price')->textInput() ?>
    <?= $form->field($model, 'retail_price')->textInput() ?>
    <?= $form->field($model, 'supplier_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $suppliers,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Ընտրել'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
</div>
<div class="col-lg-4">

    <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'min_qty')->textInput(['maxlength' => true]) ?>
    <br>
    <?= $form->field($model, 'images[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
</div>
<div class="col-lg-4" style="margin-top:-8px;">
    <br >
    <?= $form->field($model, 'mac_address')->widget(MultipleInput::className(), [
        'max'               => 30,
        'min'               => 1, // should be at least 2 rows
        'allowEmptyList'    => true,
        'enableGuessTitle'  => true,
        'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
        'addButtonOptions' => [
            'class' => 'btn btn-primary',
            'label' => '<i class="fa fa-plus"></i>' // also you can use html code
        ],
        'removeButtonOptions' => [
            'label' => '<i class="fa fa-trash"></i>'
        ]
    ])->label(false);?>
    <div class="form-row">
        <div class="c-checkbox">
            <input type="checkbox"
                   value="true"
                   id="used-status"
                   class="form-control"
                   name="Product[used]"
                <?= $model->used == true ? 'checked' : ''; ?>>
            <label class="has-star" for="used-status">Օգտագործված</label>
            <div class="help-block invalid-feedback"></div>
        </div>
    </div>
    <?= $form->field($model, 'warehouse_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $physicalWarehouse,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Ընտրել'),
        ],
        'pluginOptions' => [
            'allowClear' => false
        ],
    ]) ?>
    <input type="hidden" name="Product[notice_if_move]" id="is_vip" value="0">

</div>
</div>
<div class="form-group">
    <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-primary']) ?>
    <?php if(isset($type) && $type == 'create'): ?>
        <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
    <?php endif; ?>
</div>
    <?php ActiveForm::end(); ?>
    <script>
        window.onload = function(){
            $('#product-nomenclature_product_id').on('change',function(){
                var pId = $(this).val();
                if(pId) {
                    $.ajax({
                        url: '/warehouse/product/get-product-info',
                        method: 'get',
                        dataType: 'json',
                        data: {id: pId},
                        success: function (data) {
                            if(data.individual == 'true'){
                                 $('.field-product-mac_address').show();
                                 $('#product-count').val(1).attr('disabled','disabled');
                                 $('#is_vip').val(1);

                            } else {
                                $('.field-product-mac_address').hide();
                                $('#product-count').val('').removeAttr('disabled');
                                $('#is_vip').val(0);
                            }
                        }
                    });
                }
            });
        }
    </script>
</div>