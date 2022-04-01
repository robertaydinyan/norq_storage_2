<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Analogs */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analogs-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="row" >
         <div class="col-sm-6">
              <?= $form->field($model, 'product_id', [
                    'options' => ['class' => 'form-group'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $nomiclatures,
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>
         </div>
         <?php if($model->isNewRecord){ ?>
         <div class="col-sm-5" id="analogs">
            <div class="cloned-div">
              <?= $form->field($model, 'analog_id[]', [
                    'options' => ['class' => 'form-group analogs'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $nomiclatures,
                    'maintainOrder' => true,
                    'hideSearch' => false,
                    'options' => [
                        'class'=>'analogs',
                        'placeholder' => Yii::t('app', 'Select'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>
             </div>
         </div>
         <div class="col-sm-1">
            <label class="control-label">Ավելացնել</label>
             <button type="button" class="btn btn-success" onclick="copyAnalog()">+</button>
         </div>
     <?php } else { ?>
        <div class="col-sm-6" id="analogs">
            <div class="cloned-div">
              <?= $form->field($model, 'analog_id', [
                    'options' => ['class' => 'form-group analogs'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $nomiclatures,
                    'maintainOrder' => true,
                    'hideSearch' => false,
                    'options' => [
                        'class'=>'analogs',
                        'placeholder' => Yii::t('app', 'Select'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ]) ?>
             </div>
         </div>
     <?php } ?>
     </div>
 

   
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    function copyAnalog(){
        $('select.analogs').select2('destroy');
        var cl = $('#analogs .cloned-div').first().clone();
        let rowCount = $('.cloned-div').length + 1;
        $('#analogs').find('select.analogs').attr('id', function () {
            // $(this).val(null).trigger('change');
            return $(this).attr('id') + '_' + (rowCount);
        });
        $('#analogs').append(cl);
        let $nm_products = $('select.analogs');
        let $elCom = $nm_products,
            settingsCom = $elCom.attr('data-krajee-select2'),
            idCom = $elCom.attr('id');
        settingsCom = window[settingsCom];
        $nm_products.select2(settingsCom);
    }
    window.onload = function(){
        $('body').on('change','.analogs',function(){
            var el = $(this);
            $('.analogs').each( function(){
                if($(this).not(el)){
                    if(el.val()){
                       $(this).find('option [value='+el.val()+']').attr('disabled','disabled');
                   }
               }
            });
        });
    }
</script>