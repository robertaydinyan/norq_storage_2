<?php

use app\components\Pricing;
use app\modules\billing\models\AntennaIp;
use app\modules\billing\models\Services;
use app\modules\fastnet\models\BaseStation;

use app\modules\fastnet\models\Deal;
use app\modules\fastnet\models\DisabledDay;
use Carbon\Carbon;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\Deal */
/* @var $crmContact app\modules\crm\models\Contact */
/* @var $crmCompany app\modules\crm\models\Company */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $contactPassport app\modules\crm\models\ContactPassport */
/* @var $antennaIp app\modules\billing\models\AntennaIp */
/* @var $nProducts app\modules\billing\models\AntennaIp */
/* @var $shipping app\modules\billing\models\AntennaIp */
/* @var $shippingProduct app\modules\fastnet\models\Deal */
/* @var $baseStationWarehouse app\modules\billing\models\AntennaIp */
/* @var $form yii\widgets\ActiveForm */
/* @var $product app\modules\fastnet\models\Deal */



$this->registerCssFile('@web/css/plugins/file-upload/file-input.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::className()],
]);
$this->registerJsFile('@web/js/modules/crm/script.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/sweetalert/sweetalert2.all.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/crm/contact.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/addProduct.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/file-upload/file-field.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/fastnet/app.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

if (!$model->isNewRecord) {
    $pricing = new Pricing($model);
    $disabledDay = DisabledDay::find()->one();
    $allowToChangeDeal = ($pricing->virtualBalance() - $pricing->currentMonthTotalPayed()) <= $disabledDay->price;
}
?>

<style>
    .select2-container--krajee, .select2-selection__rendered {
        height: 38px !important;
    }

    .select2-selection__clear {
        line-height: 38px !important;
    }

    .select2-selection {
        height: 36px !important;
    }
    .module-service-form-card{
        margin-bottom: 20px;
    }
</style>

<div class="deal-form main-form-wrap">

    <!-- Danger message alert -->
    <?php if (Yii::$app->session->hasFlash('danger')) : ?>
        <?= \yii\bootstrap4\Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => Yii::$app->session->getFlash('danger'),
            'closeButton' => false
        ]) ?>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?php if (!$model->isNewRecord) : ?>
        <div class="module-service-form-card">
            <div class="form-row">
                <?php if (!$model->isDaily()) : ?>
                    <div class="c-checkbox">
                        <input type="checkbox" value="1" id="deal-service_change" class="form-control" name="Deal[service_change]" <?= $allowToChangeDeal ?: 'disabled' ?>>
                        <label class="has-star mb-0" for="deal-service_change"><?= Yii::t('app', 'Ծառայության փոփոխություն') ?></label>
                        <div class="help-block invalid-feedback"></div>
                    </div>

                    <?php if (!$allowToChangeDeal) : ?>
                        <div class="ml-5">
                            <h6 class="m-0 d-flex align-items-center">
                                <span><?= $disabledDay->message ?></span>
                                <span class="mx-2">-</span>
                                <span class="badge badge-danger"><?= $pricing->virtualBalance() - $pricing->currentMonthTotalPayed() ?></span>
                            </h6>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="c-checkbox" style="margin-left: 10px;">
                    <input type="checkbox"
                           value="1"
                           id="billing_bl"
                           class="form-control"
                           name="blacklist"
                        <?= $model->isNewRecord || $model->blacklist == Deal::BLACKLIST_WHITE ? 'checked' : '' ?>
                    >
                    <label class="has-star" for="billing_bl"><?= Yii::t('app', 'Հաշվապահություն') ?></label>
                    <div class="help-block invalid-feedback"></div>
                </div>

                <?php if ($model->isDaily()) : ?>
                    <span class="badge badge-success font-weight-light ml-2 p-2">
                        <?= Yii::t('app', 'Ամսական') ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($model->isNewRecord) : ?>
        <div class="module-service-form-card">
            <div class="form-row">
                <div class="c-checkbox">
                    <input type="checkbox" value="1" id="deal-is_daily" class="form-control" name="Deal[is_daily]">
                    <label class="has-star mb-0" for="deal-is_daily"><?= Yii::t('app', 'Ամսական') ?></label>
                    <div class="help-block invalid-feedback"></div>
                </div>
            </div>
        </div>

        <div class="module-service-form-card">

            <div class="form-row">
                <?= $form->field($model, 'deal_number', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true]); // 'disabled' => true ?>

                <?= $form->field($model, 'contact_id', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model->getAllContact(),
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <div class="c-checkbox custom-chec">
                    <input type="checkbox"
                           value="1"
                           id="deal-is_provider"
                           class="form-control"
                           name="Deal[is_provider]"
                        <?= $model->is_provider == 1 && !$model->isNewRecord ? 'checked' : ''; ?>>
                    <label class="has-star" for="deal-is_provider"><?= Yii::t('app', 'Պրովայդեր') ?></label>
                    <div class="help-block invalid-feedback"></div>
                </div>

            </div>

            <div class="form-row">
                <?= $form->field($model, 'user_type', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model::USER_TYPE,
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($model, 'crm_contact_id', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model->getAllCrmContact(),
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'disabled' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>

                <?= $form->field($model, 'crm_company_id', [
                    'options' => ['class' => 'form-group col-md-4'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $model->getAllCrmCompany(),
                    'maintainOrder' => true,
                    'hideSearch' => true,
                    'disabled' => true,
                    'options' => [
                        'placeholder' => Yii::t('app', 'Ընտրել'),
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>

            <div class="c-checkbox">
                <input type="checkbox"
                       value="1"
                       id="is_new_client"
                       class="form-control"
                       name="is_new_client"
                >
                <label class="has-star" for="is_new_client"><?= Yii::t('app', 'Նոր հաճախորդ') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

            <div class="c-checkbox" style="margin-left: 10px;">
                <input type="checkbox"
                       value="1"
                       id="billing_bl"
                       class="form-control"
                       name="blacklist"
                       checked
                >
                <label class="has-star" for="billing_bl"><?= Yii::t('app', 'Հաշվապահություն') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

            <div id="deal-customer-addresses" class="mt-4" style="display: none">
                <div class="form-group mb-0">
                    <label class="control-label" for="address_id">Հասցե</label>
                    <?= Select2::widget([
                        'name' => 'address_id',
                        'data' => [],
                        'theme' => Select2::THEME_KRAJEE,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Ընտրել Հասցե'),
                            'id' => 'address_id',
                            'multiple' => true,
                            'data-url' => Url::toRoute(['get-addresses-by-customer'])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="form-row module-service-form-card" id="crm-contact_for_deal" style="display: none">
            <h3>Ֆիզիկական անձ</h3>

            <div class="row">

                <?= $form->field($crmContact, 'name', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Անուն') ?>

                <?= $form->field($crmContact, 'surname', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Ազգանուն') ?>

                <?= $form->field($crmContact, 'middle_name', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Հայրանուն') ?>


                <?= $form->field($crmContact, 'email', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Էլ․ հասցե') ?>

                <?= $form->field($crmContact, 'dob', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'minuteStep' => 1,
                    'minDate' => 0,
                    'todayHighlight' => true,
                    'changeYear' => true,
                    'changeMonth' => true,
                ],'type' => DatePicker::TYPE_INPUT])->label('Ծննդյան ամսաթիվ'); ?>

                <?= $form->field($crmContact, 'passport_number', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Անձնագրի սերիա') ?>

                <?= $form->field($crmContact, 'visible_by', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('ՈՒմ կողմից') ?>

                <?= $form->field($crmContact, 'when_visible', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'minuteStep' => 1,
                    'minDate' => 0,
                    'todayHighlight' => true,
                    'changeYear' => true,
                    'changeMonth' => true,
                ],'type' => DatePicker::TYPE_INPUT])->label('Երբ է տրվել'); ?>

                <?= $form->field($crmContact, 'valid_until', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->widget(DatePicker::classname(), ['pluginOptions' => [
                    'format' => 'dd-mm-yyyy',
                    'startDate' => date("Y-m-d"),
                    'autoclose'=>true
                ],'type' => DatePicker::TYPE_INPUT])->label('Ուժի մեջ է մինչև'); ?>

                <?= $form->field($crmContact, 'phone[]', [
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
                <div class="row">
                    <div class="col-sm-6">

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

        </div>

        <div class="form-row module-service-form-card" id="crm-company_for_deal" style="display: none">
            <h3>Կազմակերպություն</h3>

            <div class="row">
                <?= $form->field($crmCompany, 'name', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Անվանում') ?>

                <?= $form->field($crmCompany, 'email', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('Էլ․ հասցե') ?>

                <?= $form->field($crmCompany, 'passport_number', [
                    'options' => ['class' => 'form-group col-md-4']
                ])->textInput(['maxlength' => true])->label('ՀՎՀՀ') ?>

                <?= $form->field($crmCompany, 'phone[]', [
                    'options' => ['class' => 'form-group col-md-4'],
                    'template' => '
                        {label}
                        <div class="input-group date mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text js--add-phone-company-field kv-date-remove text-secondary">
                                    <i class="fal fa-plus"></i>
                                </span>
                            </div>
                            <div class="input-group-prepend d-none">
                                <span class="input-group-text js--remove-phone-company-field kv-date-remove">
                                    <i class="fas fa-times"></i>
                                </span>
                            </div>
                            {input}
                        </div>
                        {error}
                    ',
                ])->textInput(['maxlength' => true])->label('Հեռախոս') ?>
            </div>

        </div>

        <!-- Address -->
        <div id="deal-addresses" style="display: none" class="module-service-form-card border-primary position-relative col-md-12 mt-3">

            <!-- If address is new -->
            <?php if ($crmCompany->isNewRecord) : ?>

                <div class="row deal-address-block">

                    <div class="col-sm-12 mt-3">
                        <hr data-content="<?= Yii::t('app', 'Հասցե') ?>" class="hr-text d-none">
                    </div>

                    <div class="col-sm-12 mt-3">
                        <?= $form->field($address, 'country_id[]', [
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
                                'data-url' => Url::to(['deal/get-regions-by-country'])
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
                                'disabled' => true,
                                'data-url' => Url::to(['deal/get-cities-by-region'])
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
                                'data-url' => Url::to(['deal/get-streets-by-city']),
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
                                'data-url' => Url::to(['deal/get-streets-by-community']),
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
<!---->
<!--                    <div class="col-sm-4" style="margin-left: auto">-->
<!--                        <div class="c-checkbox">-->
<!--                            <input type="checkbox"-->
<!--                                   value="1"-->
<!--                                   id="installation-address-checkbox"-->
<!--                                   name="ContactAdress[InstallationAddress][]"-->
<!--                                   class="form-control add-address-checkbox"-->
<!--                            >-->
<!--                            <label class="has-star" for="installation-address-checkbox">Տեղադրման հասցեն է</label>-->
<!--                            <div class="help-block invalid-feedback"></div>-->
<!--                        </div>-->
<!--                    </div>-->
<!---->
                    <div class="col-sm-4">
                        <div class="remove-address d-none float-right">
                            <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Ջնջել') ?></span>
                        </div>
                    </div>

                </div>
            <?php endif; ?>

            <div class="add-address">
                <span class="card-action-btn-add-address">Ավելացնել</span>
            </div>

        </div>
        <!-- .end Address -->
    <?php endif; ?>
    <div id="products-module" style="display: block;" class="form-row module-service-form-card" style="display: block">
        <?php if ($crmCompany->isNewRecord) : ?>
            <h3>Տեղադրված ապրանքներ</h3>
            <div class="row">
                <div class="col-sm-4" >
                    <?= '<label class="control-label">Ապրանքի անուն</label>' ?>
                    <?= $form->field($nProduct, 'id[]', [
                        'template' => '{input}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => $nProducts,
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'n-product-select',
                            'id' => 'n-product-id',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                            'data-url' => Url::to(['deal/get-mac-address-by-warehouse'])
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-sm-4 select-mac-address" style="display: none">
                    <?= '<label class="control-label">MAC հասցե</label>' ?>
                    <?= $form->field($shippingProduct, 'product_id[]', [
                        'template' => '{input}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'mac-address-select',
                            'id' => 'mac-address-id',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                            'disabled' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>

                <div class="col-sm-4 count-input" style="display: none">
                    <label class="control-label" for="shippingproduct-count">Ապրանքի քանակ</label>
                    <div class="sk-floating-label mb-3 count-input field-shippingproduct-count" placeholder="">
                        <input type="number" id="shippingproduct-count" class="form-control input-count" name="ShippingProduct[count][]" autocomplete="off">
                        <div class="help-block"></div>
                    </div>
                    <input type="hidden" class="product-id-input" name="ShippingProduct[product_individual_id][]" value="">
                </div>

                <!--            <div class="col-sm-4 product-nProduct"></div>-->
                <div class="col-sm-4">
                    <?= '<label class="control-label">Տեղափոխության տեսակ</label>' ?>
                    <?= $form->field($shipping, 'shipping_type[]', [
                        'template' => '{input}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => \app\modules\warehouse\models\Shipping::getTypeByDeal(),
                        'maintainOrder' => true,
                        'hideSearch' => true,
                        'options' => [
                            'class' => 'shipping-type-select',
                            'id' => 'shipping-type-id',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])?>
                </div>
                <div class="col-sm-4">
                    <?= '<label class="control-label">Բազային կայան</label>' ?>
                    <?= $form->field($baseWarehouse, 'id[]', [
                        'template' => '{input}{error}{hint}',
                        'options' => ['class' => 'form-group sk-floating-label'],
                    ])->widget(Select2::className(), [
                        'theme' => Select2::THEME_KRAJEE,
                        'data' => $baseStationWarehouse,
                        'maintainOrder' => true,
                        'options' => [
                            'class' => 'base-station-warehouse-select',
                            'id' => 'base-station-warehouse-id',
                            'placeholder' => Yii::t('app', 'Ընտրել'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])?>
                </div>
                <div class="col-sm-4">
                    <div class="remove-address d-none float-right">
                        <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-product"><?= Yii::t('app', 'Ջնջել') ?></span>
                    </div>
                </div>
            </div>
            <div class="add-address">
                <span class="card-action-btn-add-product">Ավելացնել</span>
            </div>
        <?php endif; ?>

    </div>

        <div class="module-service-form-card">

        <div class="form-row">

            <?= $form->field($model, 'service_type', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'data' => $model::TARIFF_TYPE,
                'theme' => Select2::THEME_KRAJEE,
                'maintainOrder' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                    'data-url' => Url::to(["deal/get-services"]),
                    'disabled' => !$model->isNewRecord && $model->isDaily()
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'connect_id', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                    'data-price' => 0,
                    'data-url' => Url::to(["deal/connect-price"]),
                    'class' => 'check_deal_price change_input',
                    'disabled' => !$model->isNewRecord && $model->isDaily()
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'connect_price', [
                'options' => ['class' => 'form-group col-md-4']
            ])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'base_station_id', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => BaseStation::all(),
                'maintainOrder' => true,
                'options' => [
                    'data-url' => Url::to(["deal/get-ips"]),
                    'data-model-id' => !$model->isNewRecord ? $model->deal_number : '',
                    'placeholder' => Yii::t('app', 'Ընտրել')
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>

            <?php $model->base_station_ip = $model->selectedIps(); ?>

            <?= $form->field($model, 'base_station_ip', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => $model->availableIPList($model->base_station_id),
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                ],
                'pluginOptions' => [
                    'multiple' => true,
                    'allowClear' => true
                ],
            ]) ?>

            <?= $form->field($model, 'connect_type', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => $model::CONNECT_TYPE,
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                    'data-url' => Url::to(["deal/get-antenna"]),
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="form-row antenna-ip-address" style="display: <?= !$model->isNewRecord && $model->connect_type == 2 ?: 'none' ?>">
            <div class="col-md-4"></div>
            <div class="col-md-4"></div>

            <?php $model->antenna_ip = $model->antennaIpAddress ?>

            <?= $form->field($model, 'antenna_ip', [
                'options' => ['class' => 'form-group col-md-4'],
            ])->widget(Select2::className(), [
                'theme' => Select2::THEME_KRAJEE,
                'data' => ArrayHelper::map(AntennaIp::getList(), 'id', 'ip_address'),
                'maintainOrder' => true,
                'hideSearch' => false,
                'options' => [
                    'placeholder' => Yii::t('app', 'Ընտրել'),
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]) ?>
        </div>

        <div class="js--add-multiple-ip form-row">

            <!-- If action is create -->
            <?php if ($model->isNewRecord) : ?>
                <?= $form->field($model, 'ip[]', [
                    'options' => [
                        'class' => 'form-group col-md-4'
                    ],
                    'template' => '
                            {label}
                            <div class="input-group date mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text js--add-ip-field kv-date-remove text-secondary">
                                        <i class="fal fa-plus"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend d-none">
                                    <span class="input-group-text js--remove-ip-field kv-date-remove">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text kv-date-remove text-secondary pr-0">
                                        <div class="c-checkbox custom-chec mt-0 pt-2">
                                            <input type="checkbox"
                                                   value="0"
                                                   id="deal-ip_status"
                                                   class="form-control"
                                                   name="Deal[ip_status][]">
                                            <label class="has-star deal-ip_status" for="deal-ip_status"><small>' . $model->getAttributeLabel('ip_status') . '</small></label>
                                            <div class="help-block invalid-feedback"></div>
                                        </div>
                                    </span>
                                </div>
                                {input}
                            </div>
                            {error}
                        ',
                    'inputOptions' => [
                        'class' => 'form-control krajee-datepicker',
                    ]]);
                ?>
            <?php else: ?>

                <!-- If action is update and ip addresses exists -->
                <?php if (!empty($ipAddresses)) : ?>
                    <?php foreach ($ipAddresses as $ipKey => $ip) : ?>

                        <?php $ipStatusCheckedStatus = $ip->status == 1 ? 'checked' : '' ?>

                        <?= $form->field($model, 'ip[]', [
                            'options' => [
                                'class' => 'form-group col-md-4'
                            ],
                            'template' => '
                                    {label}
                                    <div class="input-group date mb-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text js--add-ip-field kv-date-remove text-secondary">
                                                <i class="fal fa-plus"></i>
                                            </span>
                                        </div>
                                        <div class="input-group-prepend d-none">
                                            <span class="input-group-text js--remove-ip-field kv-date-remove">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </div>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text kv-date-remove text-secondary pr-0">
                                                <div class="c-checkbox custom-chec mt-0 pt-2">
                                                    <input type="checkbox"
                                                           value="' . $ip->status . '"
                                                           id="deal-ip_status-' . $ipKey . '"
                                                           class="form-control"
                                                           name="Deal[ip_status][]" ' . $ipStatusCheckedStatus . '>
                                                    <label class="has-star deal-ip_status" for="deal-ip_status-' . $ipKey . '"><small>' . $model->getAttributeLabel('ip_status') . '</small></label>
                                                    <div class="help-block invalid-feedback"></div>
                                                </div>
                                            </span>
                                        </div>
                                        <input type="text" id="deal-ip-' . $ipKey . '" class="form-control krajee-datepicker" name="Deal[ip][]" value="' . $ip->address . '" autocomplete="off">
                                    </div>
                                    {error}
                                ',
                            'inputOptions' => [
                                'class' => 'form-control krajee-datepicker',
                            ]]);
                        ?>
                    <?php endforeach; ?>
                <?php else: ?>

                    <!-- If action is update and ip addresses empty -->
                    <?= $form->field($model, 'ip[]', [
                        'options' => [
                            'class' => 'form-group col-md-4'
                        ],
                        'template' => '
                            {label}
                            <div class="input-group date mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text js--add-ip-field kv-date-remove text-secondary">
                                        <i class="fal fa-plus"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend d-none">
                                    <span class="input-group-text js--remove-ip-field kv-date-remove">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </div>
                                <div class="input-group-prepend">
                                    <span class="input-group-text kv-date-remove text-secondary pr-0">
                                        <div class="c-checkbox custom-chec mt-0 pt-2">
                                            <input type="checkbox"
                                                   value="0"
                                                   id="deal-ip_status"
                                                   class="form-control"
                                                   name="Deal[ip_status][]">
                                            <label class="has-star deal-ip_status" for="deal-ip_status"><small>' . $model->getAttributeLabel('ip_status') . '</small></label>
                                            <div class="help-block invalid-feedback"></div>
                                        </div>
                                    </span>
                                </div>
                                {input}
                            </div>
                            {error}
                        ',
                        'inputOptions' => [
                            'class' => 'form-control krajee-datepicker',
                        ]]);
                    ?>
                <?php endif; ?>
            <?php endif; ?>

        </div>


    </div>

    <div class="form-row module-service-form-card" style="display: block">
        <h3>Պարտավորեցնող պայմանագիր</h3>
        <div class="row">

            <?php if ($model->isNewRecord || (!$model->isNewRecord && !$model->isDaily())) : ?>
                <?= $form->field($model, 'contract_start', [
                    'options' => ['class' => 'form-group col-md-4 is-not-daily']
                ])->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'minuteStep' => 1,
                    'minDate' => 0,
                    'todayHighlight' => true,
                    'startDate' => date("Y-m-d"),
                    'changeYear' => true,
                    'changeMonth' => true,

                ]]) ?>

                <?= $form->field($model, 'contract_end', [
                    'options' => ['class' => 'form-group col-md-4 is-not-daily']
                ])->widget(DatePicker::classname(), ['pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd-mm-yyyy',
                    'minuteStep' => 1,
                    'minDate' => 0,
                    'todayHighlight' => true,
                    'startDate' => date("Y-m-d"),
                    'changeYear' => true,
                    'changeMonth' => true,
                ]]) ?>
            <?php endif; ?>

            <!-- Contract finish month for daily -->
            <?= $form->field($model, 'daily_finish_month', [
                'options' => [
                    'class' => 'form-group col-md-4 is-daily',
                    'style' => $model->isNewRecord || (!$model->isNewRecord && !$model->isDaily()) ? 'display: none;' : ''
                ]
            ])->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true,
                'startDate' => Carbon::now()->format('Y-m-d'),
                'changeYear' => true,
                'changeMonth' => true,
            ]]) ?>

            <?= $form->field($model, 'penalty', [
                'options' => ['class' => 'form-group col-md-4']
            ])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'speed_date_start', [
                'options' => ['class' => 'form-group col-md-6']
            ])->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'minuteStep' => 1,
                'minDate' => 0,
                'todayHighlight' => true,
                'startDate' => date("Y-m-d"),
                'changeYear' => true,
                'changeMonth' => true,
            ]]) ?>

            <?= $form->field($model, 'speed_date_end', [
                'options' => ['class' => 'form-group col-md-6']
            ])->widget(DatePicker::classname(), ['pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
                'minuteStep' => 1,
                'minDate' => 0,
                'todayHighlight' => true,
                'startDate' => date("Y-m-d"),
                'changeYear' => true,
                'changeMonth' => true,
            ]]) ?>

            <?= $form->field($model, 'binding_speed', [
                'options' => ['class' => 'form-group col-md-4']
            ])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'down_binding_speed', [
                'options' => ['class' => 'form-group col-md-4']
            ])->textInput(['maxlength' => true]) ?>

            <div class="c-checkbox custom-chec">
                <input type="checkbox"
                       value="1"
                       id="deal-is_wifi"
                       class="form-control"
                       name="Deal[is_wifi]"
                    <?= $model->is_wifi == 1 && !$model->isNewRecord ? 'checked' : ''; ?>>
                <label class="has-star" for="deal-is_wifi"><?= Yii::t('app', 'WI-FI') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>

            <?php $display = $model->is_wifi == 1 && !$model->isNewRecord ? 'block' : 'none' ?>
            <?= $form->field($model, 'wifi_code', [
                'options' => ['class' => 'form-group col-md-4', 'style' => 'display: ' . $display]
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <!-- Deal sale block -->
    <div class="form-row module-service-form-card" style="display: block">
        <h3>Զեղչի տեսակներ</h3>
        <div class="row">
            <?= $form->field($model, 'electricity', [
                'options' => ['class' => 'form-group col-md-4 change_input']
            ])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'discount', [
                'options' => ['class' => 'form-group col-md-4 change_input']
            ])->textInput(['maxlength' => true]) ?>

            <div class="c-checkbox custom-chec">
                <input type="checkbox"
                       value="1"
                       id="deal-free"
                       class="form-control"
                       name="Deal[free]"
                    <?= $model->is_provider == 1 && !$model->isNewRecord ? 'checked' : ''; ?>>
                <label class="has-star" for="deal-free"><?= Yii::t('app', 'Անվճար') ?></label>
                <div class="help-block invalid-feedback"></div>
            </div>
        </div>
    </div>

    <div class="form-row module-service-form-card show_dis_price_deal" style="display: <?=!$model->isNewRecord && $model->user_type == 1 ? 'block' : 'none'?>">
        <h3>Անջատման նվազագույն գումար կազմակերպությունների համար</h3>
        <div class="row">
            <?= $form->field($model, 'disabled_price_deal_c', [
                'options' => ['class' => 'form-group col-md-4 change_input']
            ])->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Պահպանել'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
ob_start();
?>
<script>
    getPacket($('#deal-service_type'), <?= $model->connect_id ?>);
    let $body = $('body');
</script>

<?php
$this->registerJs(str_replace(['<script>', '</script>'], '', ob_get_clean()), View::POS_READY);
?>
