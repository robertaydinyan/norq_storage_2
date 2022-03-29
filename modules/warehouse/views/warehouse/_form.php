<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use Carbon\Carbon;
use kartik\date\DatePicker;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $dataUsers app\modules\warehouse\models\Warehouse */
/* @var $responsiblePersons app\modules\warehouse\models\Warehouse */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/plugins/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/formWarehouse.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>

<div class="warehouse-form col-lg-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $warehouse_types,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Select'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
    <?= $form->field($model, 'group_id', [
        'options' => ['class' => 'form-group hide'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $warehouse_groups,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Select'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
    <?= $form->field($model, 'name_hy')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsible_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $dataUsers,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Select'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>
    <script>
        window.onload = function (){
            $('#warehouse-type').on('change',function(){
                if($(this).val() == 2){
                    $('.field-warehouse-group_id').show();
                    $('.c-checkbox').hide();
                } else {
                    $('.field-warehouse-group_id').hide();
                    $('.c-checkbox').show();
                    $('#warehouse-name').val(null);
                }
            })
            $('#warehouse-responsible_id').on('change',function(){
                if($('#warehouse-type').val() == 2){
                    $('#warehouse-name').val($( "#warehouse-responsible_id option:selected" ).text());
                }
            })
        }
    </script>
</div>


