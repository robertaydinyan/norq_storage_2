<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $groupProducts app\modules\warehouse\models\NomenclatureProduct */
/* @var $qtyTypes app\modules\warehouse\models\NomenclatureProduct */
/* @var $tableTreeGroups app\modules\warehouse\models\NomenclatureProduct */
/* @var $manufacturers app\modules\warehouse\models\Manufacturer[] */
/* @var $form yii\widgets\ActiveForm */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="nomenclature-product-form ">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
    <div class="col-lg-8">
        <?= $form->field($model, 'vendor_code_hy')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'vendor_code_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'vendor_code_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name_hy')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name_ru')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'min_qty')->textInput() ?>

        <?= $form->field($model, 'expenditure_article')->textInput() ?>

        <?= $form->field($model, 'is_vat')->textInput() ?>

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

        <?= $form->field($model, 'other')->textInput() ?>


        <?= $form->field($model, 'qty_for_notice')->textInput() ?>


    <div class="form-row" style="margin-left:10px;">
        <?= $form->field($model, 'is_vip')
            ->checkBox([
                'label' => 'Vip',
                'style' => 'margin-bottom:4px;',
                'id' => 'vip-status'
            ]); ?>
    </div>
    <?php $model->production_date = date('Y-m-d', strtotime($model->production_date));  ?>
    <?= $form->field($model, 'production_date',[
        'options' => ['class' => 'form-group']
    ])->widget(DatePicker::classname(),[ 'pluginOptions' => [
        'autoclose'      => true,
        'format'         => 'dd-mm-yyyy',
        'minuteStep'     => 1,
        'minDate'        => 0,
        'todayHighlight' => true,
        'startDate'      => date("Y-m-d"),
        'changeYear'     => true,
        'changeMonth'    => true,
    ]]); ?>

    <div class="form-row" style="margin-left:10px;">
        <?= $form->field($model, 'individual')
            ->checkBox([
                'label' => Yii::t('app', 'Individual'),
                'style' => 'margin-bottom:4px;',
                'id' => 'individual-status'
            ]); ?>
    </div>

        <?= $form->field($model, 'qty_type_id', [
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
        <?php if($model->img ){ ?>
            <img src="<?php echo $model->img;?>" width="200" alt="">
        <?php } ?>
        <label class="control-label"><?php echo Yii::t('app', 'Image'); ?></label>
        <input type="file" name="image" >

    </div>
    <div class="col-lg-4">


        <label><?php echo Yii::t('app', 'Group');?></label>
        <ul class="file-tree" style="border:1px solid lightgrey;padding: 20px;padding-left: 30px;">
            <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name_' . $lang] ?></span>
                    <ul style="display: block;">
                        <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table.php', [
                            'tableTreeGroup' => $tableTreeGroup,
                            'id' => $model->group
                            //'groupProducts' => $groupProducts
                        ]); ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    </div>
    </div>
    <br>
<!--    --><?php //if($modal->isNewRecord){ ?>
<!--    <div class="form-group">-->
<!--        --><?//= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary','disabled'=>'disabled']) ?>
<!--        --><?php //if(isset($type) && $type == 'create'): ?>
<!--            --><?//= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
<!--        --><?php //endif; ?>
<!--    </div>-->
<!--    --><?php //} else { ?>
<!--    --><?php //} ?>

         <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    <?php if(isset($type) && $type == 'create'): ?>
        <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
    <?php endif; ?>
    <?php ActiveForm::end(); ?>

</div>
<?php if($model->isNewRecord){ ?>
<script>
    window.onload = function(){
         $(document).on('change','.ctr', function(){
                $('.ctr').removeAttr('checked');
                if ($(this).is(':checked')) {
                    $(this).attr('checked','checked');
                    $('[type="submit"]').removeAttr('disabled');
                } else {
                     $('[type="submit"]').attr('disabled','disabled');
                }
            });
     }
</script>
<?php } ?>