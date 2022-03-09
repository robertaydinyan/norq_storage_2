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
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="nomenclature-product-form ">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
    <div class="col-lg-8">
    <?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'min_qty')->textInput() ?>

        <?= $form->field($model, 'qty_for_notice')->textInput() ?>
    <div class="form-row" style="margin-left:10px;">
            <div class="c-checkbox">
                <input type="checkbox"
                       value="1"
                       id="vip-status"
                       class="form-control"
                       name="NomenclatureProduct[is_vip]"
                    <?= $model->is_vip == 1 ? 'checked' : ''; ?>>
                <label class="has-star" for="vip-status"><?= Yii::t('app', 'Vip') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

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
            <div class="c-checkbox">
                <input type="checkbox"
                       value="true"
                       id="individual-status"
                       class="form-control"
                       name="NomenclatureProduct[individual]"
                    <?= $model->individual == 'true' ? 'checked' : ''; ?>>
                <label class="has-star" for="individual-status"><?= Yii::t('app', 'Individual') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

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
                <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name'] ?></span>
                    <ul style="display: block;">
                        <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table.php', [
                            'tableTreeGroup' => $tableTreeGroup,
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
    <?php if($modal->isNewRecord){ ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary','disabled'=>'disabled']) ?>
    </div>
    <?php } else { ?>
         <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
    <?php } ?>
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