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
/* @var $address app\modules\warehouse\models\Warehouse */
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
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsible_id', [
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

    <div class="form-row" style="margin-left: auto">
        <div class="c-checkbox">
            <input type="checkbox"
                   value="true"
                   id="address-checkbox"
                   class="form-control add-address-checkbox"
                >
            <label class="has-star" for="address-checkbox"><?php echo Yii::t('app', 'Add an address'); ?></label>
            <div class="help-block invalid-feedback"></div>
        </div>

    </div>

    <div id="deal-addresses" class="module-service-form-card border-primary position-relative col-md-12 mt-3" style="display: none">
        <div class="row deal-address-block">

            <div class="col-sm-12 mt-3">
                <hr data-content="<?= Yii::t('app', 'Address') ?>" class="hr-text d-none">
            </div>

            <div class="col-sm-12 mt-3">
                <?= $form->field($address, 'country_id[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => \app\modules\billing\models\Services::getAllCountries(),
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'country-select',
                        'id' => 'countries_comp',
                        'placeholder' => Yii::t('app', 'Select'),
                        'data-url' => \app\components\Url::to(['/fastnet/deal/get-regions-by-country'])
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($address, 'region_id[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'region-select',
                        'id' => 'regions_comp',
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                        'data-url' => Url::to(['/fastnet/deal/get-cities-by-region'])
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($address, 'city_id[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'city-select',
                        'id' => 'city_comp',
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                        'data-url' => Url::to(['/fastnet/deal/get-streets-by-city']),
                        'disabled' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($address, 'community_id[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => [],
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'community-select',
                        'id' => 'community_id',
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                        'data-url' => Url::to(['/fastnet/deal/get-streets-by-community']),
                        'disabled' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
            <div class="col-sm-4">
                <?= $form->field($address, 'street[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'maintainOrder' => true,
                    'options' => [
                        'class' => 'street-select',
                        'id' => 'street_comp',
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                        'disabled' => true,
                    ],
                    'pluginOptions' => [
                        'tags' => true,
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($address, 'housing[]', [
                    'options' => ['class' => 'form-group sk-floating-label'],
                    'template' => '{input}{label}{error}{hint}'
                ])->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($address, 'house[]', [
                    'options' => ['class' => 'form-group sk-floating-label'],
                    'template' => '{input}{label}{error}{hint}'
                ])->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <?= $form->field($address, 'apartment[]', [
                    'options' => ['class' => 'form-group sk-floating-label'],
                    'template' => '{input}{label}{error}{hint}'
                ])->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-sm-4">
                <div class="remove-address d-none float-right">
                    <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Ջնջել') ?></span>
                </div>
            </div>

        </div>

    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
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


