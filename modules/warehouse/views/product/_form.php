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
    <div class="col-4">
        <?= $form->field($model, 'product_name')->textInput() ?>
        <?= $form->field($model, 'article')->textInput() ?>
        <?= $form->field($model, 'price')->textInput() ?>
        <?= $form->field($model, 'count')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
    </div>
     <div class="col-4">
        <?= $form->field($model, 'qty_type', [
            'options' => ['class' => 'form-group'],
        ])->widget(Select2::className(), [
            'theme' => Select2::THEME_KRAJEE,
            'data' => $qtyTypes,
            'maintainOrder' => true,
            'options' => [
                'placeholder' => Yii::t('app', 'Select'),
            ],
            'pluginOptions' => [
                'tags' => true,
                'allowClear' => true
            ],
        ]) ?>
       <?= $form->field($model, 'manufacturer', [
                    'options' => ['class' => 'form-group'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $manufacturers,
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>
                 <?= $form->field($model, 'not_is_vat_price')->textInput() ?>
            </div>
       
         <div class="col-4">

            <label><?php echo Yii::t('app', 'Group'); ?></label>
            <ul class="file-tree" style="border:1px solid lightgrey;padding: 20px;padding-left: 30px;">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder"><span> <?= $tableTreeGroup['name'] ?></span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_mm.php', [
                                'tableTreeGroup' => $tableTreeGroup,
                                'id' => $model->group_id
                                //'groupProducts' => $groupProducts
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
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