<?php

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Regions;
use app\modules\billing\models\Services;
use app\modules\fastnet\models\Streets;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\modules\crm\models\Contact */
/* @var $form yii\widgets\ActiveForm */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $contactPassport app\modules\crm\models\ContactPassport */


$this->registerCssFile('@web/css/plugins/file-upload/file-input.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::className()],
]);
$this->registerJsFile('@web/js/modules/crm/script.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/sweetalert/sweetalert2.all.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/crm/contact.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/file-upload/file-field.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="form-row">

        <?= $form->field($model, 'name', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'surname', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'middle_name', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

    </div>
    <div class="form-row">

        <?= $form->field($model, 'dob', [
            'options' => ['class' => 'form-group col-md-4']
        ])->widget(DatePicker::classname(), ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'minuteStep' => 1,
            'minDate' => 0,
            'todayHighlight' => true,
            'changeYear' => true,
            'changeMonth' => true,
        ], 'type' => DatePicker::TYPE_INPUT]) ?>

        <?= $form->field($model, 'passport_number', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'visible_by', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true])->label('ՈՒմ կողմից') ?>
    </div>
    <div class="form-row">
        <?= $form->field($model, 'when_visible', [
            'options' => ['class' => 'form-group col-md-4']
        ])->widget(DatePicker::classname(), ['pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'minuteStep' => 1,
            'minDate' => 0,
            'todayHighlight' => true,
            'changeYear' => true,
            'changeMonth' => true,
        ], 'type' => DatePicker::TYPE_INPUT]) ?>
        <?= $form->field($model, 'valid_until', [
            'options' => ['class' => 'form-group col-md-4']
        ])->widget(DatePicker::classname(), ['pluginOptions' => [
            'format' => 'yyyy-mm-dd',
            'autoclose' => true
        ], 'type' => DatePicker::TYPE_INPUT])->label('Ուժի մեջ է մինչև'); ?>
        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group col-md-4']
        ])->textInput(['maxlength' => true]) ?>
    </div>

    <?php if ($model->isNewRecord) : ?>
        <div class="row">
            <div class="col-sm-12">
                <!-- Passport images -->
                <label for=""><?= Yii::t('app', 'Անձնագրի նկար') ?></label>
                <div class="images">
                    <div class="pic">
                        <?= Yii::t('app', 'Ավելացնել') ?>
                        <?= $form->field($contactPassport, 'contactPassport[]', [
                            'options' => ['class' => 'form-group sk-floating-label m-0'],
                            'template' => '{input}{error}{hint}'
                        ])->fileInput(['class' => 'file-uploader d-none', 'multiple' => true, 'accept' => 'image/*']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <?= $form->field($model, 'phone[]', [
                'options' => ['class' => 'form-group col-md-4'],
                'template' => '
                            {label}
                            <div class="input-group date mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text js--add-phone-field kv-date-remove text-secondary">
                                        <i class="fal fa-plus"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend d-none">
                                    <span class="input-group-text js--remove-phone-field kv-date-remove">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                                {input}
                            </div>
                            {error}
                        ',
            ])->textInput(['maxlength' => true])->label('Հեռախոս') ?>
        </div>
    <?php else : ?>

        <div class="row">
            <div class="col-sm-12">
                <!-- Passport images -->
                <label for=""><?= Yii::t('app', 'Անձնագրի նկար') ?></label>
                <div class="images">
                    <div class="pic">
                        <?= Yii::t('app', 'Ավելացնել') ?>
                        <?= $form->field($contactPassport, 'contactPassport[]', [
                            'options' => ['class' => 'form-group sk-floating-label m-0'],
                            'template' => '{input}{error}{hint}'
                        ])->fileInput(['class' => 'file-uploader d-none', 'multiple' => true, 'accept' => 'image/*']) ?>
                    </div>
                    <?php if (count($model->requisiteFiles) > 0) : ?>
                        <?php foreach ($model->requisiteFiles as $key => $imgName) : ?>
                            <?php $urlImage = $imgName['image'] ?>
                            <div class="img new-img"
                                 style="background-image: url('/contact_passport/<?= $urlImage ?>') ; margin-right: 6px">
                                <span class="remove-pic result_file"
                                      data-file-id="<?= $imgName['id'] ?>"
                                      data-file-url="<?= Url::to(['contact/remove-passport-image']) ?>"
                                      data-title="<?= Yii::t('app', 'Ջնջե՞լ ֆայլը') ?>"
                                      data-confirm-text="<?= Yii::t('app', 'Ջնջել') ?>"
                                      data-cancel-text="<?= Yii::t('app', 'Չեղարկել') ?>"
                                ><i class="fal fa-times"></i></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (count($model->contactPhone) > 0) : ?>
            <div class="form-row">
                <?php $i = 0 ?>
                <?php foreach ($model->contactPhone as $key => $val) : ?>
                    <?php $i++ ?>
                    <?= $form->field($model, 'phone[]', [
                        'options' => ['class' => 'form-group col-md-4'],
                        'template' => '
                            {label}
                            <div class="input-group date mb-0">
                                <div class="input-group-prepend d-none">
                                    <span class="input-group-text js--remove-phone-field kv-date-remove">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                                {input}
                            </div>
                            {error}
                        ',
                    ])->textInput(['maxlength' => true, 'value' => $val['phone'] ? $val['phone'] : ''])->label("Հեռախոս $i") ?>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>
        <div class="form-row">
            <?= $form->field($model, 'phone[]', [
                'options' => ['class' => 'form-group col-md-4'],
                'template' => '
                        {label}
                        <div class="input-group date mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text js--add-phone-field kv-date-remove text-secondary">
                                    <i class="fal fa-plus"></i>
                                </span>
                            </div>
                            <div class="input-group-prepend d-none">
                                <span class="input-group-text js--remove-phone-field kv-date-remove">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                            {input}
                        </div>
                        {error}
                    ',
            ])->textInput(['maxlength' => true])->label('Հեռախոս') ?>
        </div>
    <?php endif; ?>

    <div id="deal-addresses" class="module-service-form-card border-primary position-relative col-md-12 mt-3">
        <?php if ($model->isNewRecord) : ?>
            <div class="row deal-address-block">
                <div class="col-sm-12 mt-3">
                    <hr data-content="<?= Yii::t('app', 'Հասցե') ?>" class="hr-text d-none">
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'country_id[]', [
                        'template' => '{input}{label}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => Services::getAllCountries(),
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'country-select',
                            'id' => 'countries_comp',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                            'data-url' => Url::to(['/fastnet/deal/get-regions-by-country'])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'region_id[]', [
                        'template' => '{input}{label}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'region-select',
                            'id' => 'regions_comp',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                            'disabled' => true,
                            'data-url' => Url::to(['/fastnet/deal/get-cities-by-region'])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'city_id[]', [
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
                    <?= $form->field($model, 'community_id[]', [
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
                    <?= $form->field($model, 'street[]', [
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
                    <?= $form->field($model, 'housing[]', [
                        'options' => ['class' => 'form-group sk-floating-label'],
                        'template' => '{input}{label}{error}{hint}'
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'house[]', [
                        'options' => ['class' => 'form-group sk-floating-label'],
                        'template' => '{input}{label}{error}{hint}'
                    ])->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'apartment[]', [
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
            <div class="add-address">
                <span class="card-action-btn-add-address">Ավելացնել</span>
            </div>
        <?php else: ?>
            <?php if (count($model->contactAddress) < 1) : ?>
                    <div class="row deal-address-block">
                        <div class="col-sm-12 mt-3">
                            <hr data-content="<?= Yii::t('app', 'Հասցե') ?>" class="hr-text d-none">
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'country_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => Services::getAllCountries(),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'country-select',
                                    'id' => 'countries_comp',
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'data-url' => Url::to(['/fastnet/deal/get-regions-by-country'])
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'region_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'region-select',
                                    'id' => 'regions_comp',
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'disabled' => true,
                                    'data-url' => Url::to(['/fastnet/deal/get-cities-by-region'])
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'city_id[]', [
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
                            <?= $form->field($model, 'community_id[]', [
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
                                    'disabled' => true,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'street[]', [
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
                            <?= $form->field($model, 'house[]', [
                                'options' => ['class' => 'form-group sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'housing[]', [
                                'options' => ['class' => 'form-group sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'apartment[]', [
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
                    <div class="add-address">
                        <span class="card-action-btn-add-address">Ավելացնել</span>
                    </div>
            <?php else: ?>
                <?php foreach ($model->contactAddress as $key => $val) : ?>
                    <div class="row deal-address-block">
                        <div class="col-sm-12">
                            <hr data-content="<?= Yii::t('app', 'Հասցե') ?>" class="hr-text <?= ($key == 0) ? 'd-none' : '' ?>">
                        </div>

                        <div class="col-sm-12">
                            <?= $form->field($model, 'id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group m-0'],
                            ])->hiddenInput(['value' => $address->id])->label(false)?>
                        </div>

                        <div class="col-sm-4">
                            <?= $form->field($model, 'country_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => Services::getAllCountries(),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'country-select',
                                    'value' => !empty($val['country_id'])? $val['country_id'] : '',
                                    'id' => 'countries_comp'.$key,
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'data-url' => Url::to(['/fastnet/deal/get-regions-by-country'])
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'region_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => ArrayHelper::map(Regions::getByCountryId($val['country_id']), 'id', 'name'),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'region-select',
                                    'value' => !empty($val['region_id'])? $val['region_id'] : '',
                                    'id' => 'regions_comp'.$key,
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'disabled' => false,
                                    'data-url' => Url::to(['/fastnet/deal/get-cities-by-region'])
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'city_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => ArrayHelper::map(Cities::getByRegionId($val['region_id']), 'id', 'name'),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'city-select',
                                    'id' => 'city_comp'.$key,
                                    'value' => !empty($val['city_id'])? $val['city_id'] : '',
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'data-url' => Url::to(['/fastnet/deal/get-streets-by-city']),
                                    'disabled' => false,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>

                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'community_id[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => ArrayHelper::map(Community::getByCityId($val['city_id']), 'id', 'name'),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'community-select',
                                    'value' => !empty($val['community_id'])? $val['community_id'] : '',
                                    'id' => 'community_id'.$key,
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'disabled' => false,
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]) ?>

                        </div>
                        <div class="col-sm-4">

                            <?= $form->field($model, 'street[]', [
                                'template' => '{input}{label}{error}{hint}',
                                'options' => ['class' => 'form-group sk-floating-label'],
                            ])->widget(Select2::className(), [
                                'theme' => Select2::THEME_KRAJEE,
                                'data' => ArrayHelper::map(Streets::getByCityId($val['city_id']), 'id', 'name'),
                                'maintainOrder' => true,
                                'options' => [
                                    'class' => 'street-select',
                                    'value' => !empty($val['street'])? $val['street'] : '',
                                    'id' => 'street_comp'.$key,
                                    'placeholder' => Yii::t('app', 'Ընտրել'),
                                    'disabled' => false,
                                ],
                                'pluginOptions' => [
                                    'tags' => true,
                                    'allowClear' => true
                                ],
                            ]) ?>

                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'house[]', [
                                'options' => ['class' => 'form-group sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true, 'value' => !empty($val['house']) ? $val['house'] : '']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'housing[]', [
                                'options' => ['class' => 'form-group sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true, 'value' => !empty($val['housing']) ? $val['housing'] : '']) ?>
                        </div>
                        <div class="col-sm-4">
                            <?= $form->field($model, 'apartment[]', [
                                'options' => ['class' => 'form-group sk-floating-label'],
                                'template' => '{input}{label}{error}{hint}'
                            ])->textInput(['maxlength' => true, 'value' => !empty($val['apartment']) ? $val['apartment'] : '']) ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="remove-address <?= $key > 0 ?: 'd-none' ?> float-right">
                                <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address result_address"
                                      data-address-id="<?= $address->id ?>"
                                      data-address-url="<?= Url::to(['fast-contact/remove-address']) ?>"
                                      data-title="<?= Yii::t('app', 'Վստա՞հ եք, որ ցանկանում եք ջնջել այս հասցեն') ?>"
                                      data-confirm-text="<?= Yii::t('app', 'Ջնջել') ?>"
                                      data-cancel-text="<?= Yii::t('app', 'Չեղարկել') ?>"
                                ><?= Yii::t('app', 'Ջնջել') ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="add-address">
                    <span class="card-action-btn-add-address">Ավելացնել</span>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="form-group" style="margin-top: 15px;">
        <?php if ($model->isNewRecord) : ?>
            <?= Html::submitButton('Պահպանել', ['class' => 'btn btn-success']) ?>
        <?php else : ?>
            <?= Html::submitButton('Թարմացնել', ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
