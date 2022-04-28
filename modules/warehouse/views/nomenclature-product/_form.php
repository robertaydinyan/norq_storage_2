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

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="nomenclature-product-form ">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-4">
                    <?= $form->field($model, 'vendor_code')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                    <?php $model->production_date = $model->production_date ? date('d-m-Y', strtotime($model->production_date)) : null; ?>
                    <?= $form->field($model, 'production_date', [
                        'options' => ['class' => 'form-group production-date']
                    ])->widget(DatePicker::classname(), ['pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                        'minuteStep' => 1,
                        'minDate' => 0,
                        'todayHighlight' => true,
                        'startDate' => date("Y-m-d"),
                        'changeYear' => true,
                        'changeMonth' => true,
                    ]]); ?>
                </div>

                <div class="col-4">
                    <?php $model->expiration_date = $model->expiration_date ? date('d-m-Y', strtotime($model->expiration_date)) : null; ?>
                    <?= $form->field($model, 'expiration_date', [
                        'options' => ['class' => 'form-group expiration-date']
                    ])->widget(DatePicker::classname(), ['pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                        'minuteStep' => 1,
                        'minDate' => 0,
                        'todayHighlight' => true,
                        'startDate' => date("Y-m-d"),
                        'changeYear' => true,
                        'changeMonth' => true,
                    ]]); ?>
                </div>

                <div class="col-4">
                    <div class="form-group">
                        <label for="expiration-days-count"><?php echo Yii::t('app', 'Days count'); ?></label>
                        <input type="text" class="form-control" id="expiration-days-count" disabled>
                        <span style="color: red" id="expiration-days-count-text"></span>
                    </div>
                </div>

                <div class="col-4">
                    <?= $form->field($model, 'series')->textInput() ?>
                </div>

                <div class="col-4">
                    <?= $form->field($model, 'ref')->textInput() ?>
                </div>

                <div class="col-4">
                    <?= $form->field($model, 'expenditure_article')->textInput() ?>
                </div>

                <div class="col-4">
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
                </div>

                <div class="col-4">
                    <?= $form->field($model, 'is_vat')->textInput() ?>
                </div>

                <div class="col-4">
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
                </div>
            </div>

            <?= $form->field($model, 'technical_description')->textArea() ?>

            <?= $form->field($model, 'comment')->textArea() ?>

            <?= $form->field($model, 'other')->textArea() ?>

            <div class="form-row" style="margin-left:10px;">
                <?= $form->field($model, 'individual')
                    ->checkBox([
                        'label' => Yii::t('app', 'Individual'),
                        'style' => 'margin-bottom:4px;',
                        'id' => 'individual-status'
                    ]); ?>
            </div>

            <!--                <div>-->
            <!--                    <span>--><?php //echo Yii::t('app', 'Barcodes'); ?><!--</span><br>-->
            <!---->
            <!--                        --><?php //if (isset($barcodes)) {
            //                            foreach ($barcodes as $barcode) {
            //                                echo sprintf(
            //                                    '<div class="d-flex form-group col-12">
            //                                                <input type="text" value="%s" name="Barcodes[%s][]" class="form-control">
            //                                                <button class="btn btn-primary remove-barcode" type="button" style="margin-left: 20px;">
            //                                                    <i style="color:red;" class="fa fa-times"></i>
            //                                                </button>
            //                                            </div>',
            //
            //                                    $barcode->code,
            //                                    $barcode->id
            //                                );
            //                            }
            //                        }?>
            <!--                    <div class="d-flex form-group col-12">-->
            <!--                        <input type="text" class="form-control" name="BarcodesNew[]">-->
            <!--                        <button class="btn btn-primary clone-barcode" type="button" style="margin-left: 20px;"><i class="fa fa-plus"></i></button>-->
            <!--                    </div>-->
            <!--                </div>-->
        </div>

        <div class="col-lg-4">
            <label><?php echo Yii::t('app', 'Group'); ?></label>
            <ul class="file-tree" style="border:1px solid lightgrey;padding: 20px;padding-left: 30px;">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder"><span> <?= $tableTreeGroup['name'] ?></span>
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

<?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php if (isset($type) && $type == 'create'): ?>
    <?= Html::button(Yii::t('app', 'Temporary storage'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))']) ?>
<?php endif; ?>
<?php ActiveForm::end(); ?>

<script>
    window.addEventListener('load', function () {
        <?php if ($model->isNewRecord) { ?>
        $(document).on('change', '.ctr', function () {
            $('.ctr').removeAttr('checked');
            if ($(this).is(':checked')) {
                $(this).attr('checked', 'checked');
                $('[type="submit"]').removeAttr('disabled');
            } else {
                $('[type="submit"]').attr('disabled', 'disabled');
            }
        });
        <?php } ?>
        let prod_v, prod = $('.production-date').find('input');
        let exp_v, exp = $('.expiration-date').find('input');
        $(prod).on('change', expDateDiff);
        $(exp).on('change', expDateDiff);

        function expDateDiff() {
            prod_v = moment(prod.val(), "DD/MM/YYYY");
            exp_v = moment(exp.val(), "DD/MM/YYYY");
            if (prod.val() && exp.val()) {
                let diff = exp_v.diff(prod_v, 'days');
                if (diff >= 0) {
                    $('#expiration-days-count').val(diff);
                    $('#expiration-days-count-text').text('');
                    $('button[type=submit]').attr('disabled', false);
                } else {
                    $('#expiration-days-count').val('');
                    $('#expiration-days-count-text').text('invalid date');
                    $('button[type=submit]').attr('disabled', true)
                }
            }
        }

        expDateDiff();

        function removeBarcode() {
            $('.remove-barcode').off().on('click', function() {
                $(this).parent().removeClass('form-group');
                $(this).prev().attr('type', 'hidden').val('');
                $(this).remove();
            });
        }
        removeBarcode();

        $('.clone-barcode').on('click', function() {
            let barcode = $(this).parent();
            let barcode_new = barcode.clone().insertBefore(barcode);
            barcode.find('input').val('');
            barcode_new.find('button').html('<i style="color:red;" class="fa fa-times"></i>').removeClass('clone-barcode').addClass('remove-barcode');
            removeBarcode();
        });
    })
</script>