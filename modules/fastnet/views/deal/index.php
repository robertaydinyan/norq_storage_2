<?php

use app\components\DailyPricing;
use app\components\Helper;
use app\modules\fastnet\models\Deal;
use kartik\daterange\DateRangePicker;
use kartik\dynagrid\DynaGrid;
use kartik\select2\Select2;
use yii\bootstrap4\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;
use app\components\Pricing;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\fastnet\models\DealSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Գործարքներ';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss('
#w0 table tbody td:nth-child(6),
#w0 table thead th:nth-child(6),
#w0 table tbody td:nth-child(7),
#w0 table thead th:nth-child(7),
#w0 table tbody td:nth-child(8),
#w0 table thead th:nth-child(8) {
    min-width: 200px;
}
#w0 table tbody td:nth-child(14),
#w0 table thead th:nth-child(14) {
    min-width: 90px;
}
#w0 table tbody td:nth-child(13),
#w0 table thead th:nth-child(13) {
    min-width: 90px;
}
#w0 table tbody td:nth-child(12),
#w0 table thead th:nth-child(12) {
    min-width: 80px;
}
#w0 table tbody td:nth-child(11),
#w0 table thead th:nth-child(11) {
    min-width: 150px;
}
#w0 table tbody td:nth-child(10),
#w0 table thead th:nth-child(10) {
    min-width: 180px;
}
#w0 table tbody td:nth-child(9),
#w0 table thead th:nth-child(9) {
    min-width: 180px;
}
.form-vertical.kv-form-bs4 .input-group {
    display: flex;
    flex-wrap: nowrap;
}

[id$="-grid-modal"] .modal-dialog.modal-lg{
    max-width: 1300px !important;
}
');

$this->registerCss('.select2-selection--single {
        height: 36px !important;;
    }
    .select2-selection__rendered {
        height: 36px !important;
    }');

if (ArrayHelper::getValue(Yii::$app->getRequest()->getQueryParam('DealSearch'), 'start_day')) {
    $this->registerCss('
    #w0 table tbody td:nth-child(11),
    #w0 table thead th:nth-child(11) {
        min-width: 300px;
    }
    ');
}
?>
<div class="deal-index card card-body border-0 shadow rounded mt-3">
    <div class="d-flex align-items-center justify-content-between">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->user->can('createDeal')) : ?>
            <?= Html::a(Yii::t('app', 'Ստեղծել Գործարք'), ['create'], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>
    </div>

    <div class="card card-body border-0 shadow-sm p-2 mb-4 mt-2 d-flex align-items-center flex-row">
        <div class="mr-3">
            <span class="payment-status" style="background-color: rgb(0, 176, 80)"></span>
            <span><?= Yii::t('app', 'Ակտիվ') ?></span>
        </div>
        <div class="mr-3">
            <span class="payment-status" style="background-color:orange;"></span>
            <span><?= Yii::t('app', 'Անջատված') ?></span>
        </div>
        <div class="mr-3">
            <span class="payment-status" style="background-color:rgb(204, 204, 204);"></span>
            <span><?= Yii::t('app', 'Արձակուրդ') ?></span>
        </div>
        <div>
            <span class="payment-status" style="background-color:rgb(255,0,0);"></span>
            <span><?= Yii::t('app', 'Խզված') ?></span>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Danger message alert -->
            <?php if (Yii::$app->session->hasFlash('danger')) : ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-danger'],
                    'body' => Yii::$app->session->getFlash('danger'),
                    'closeButton' => false
                ]) ?>
            <?php endif; ?>

            <!-- Success message alert -->
            <?php if (Yii::$app->session->hasFlash('success')) : ?>
                <?= Alert::widget([
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::$app->session->getFlash('success'),
                    'closeButton' => false
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php
    $columns = [
        [
            'attribute' => '',
            'label' => 'Բալանս',
            'format' => 'html',
            'value' => function ($model) {
                if ($model->isDaily()) {
                    $balance = new DailyPricing($model);
                } else {
                    $balance = new Pricing($model);
                }
                $price = $model->isTermination() ? $balance->virtualBalance() : $balance->virtualBalance() - $balance->currentMonthTotalPayed();

                return  "<span class='payment-status mr-3' style='background-color: {$model->status()}' title=''></span>" . round($price);
            }
        ],
        [
            'attribute' => 'is_daily',
            'format' => 'html',
            'filter' => [1 => Yii::t('app', 'Ամսական'), 0 => Yii::t('app', 'Ամսական չէ')],
            'value' => function ($model) {
                return "<div class='text-center'>{$model::YES_OR_NO[$model->is_daily]}</div>";
            }
        ],
        [
            'attribute' => 'deal_number',
            'label' => 'Պայմ. համար',
            'value' => function ($model) {
                return $model->deal_number;
            }
        ],
        [
            'attribute' => 'is_provider',
            'label' => 'Պրով․',
            'format' => 'raw',
            'filter' => [1 => Yii::t('app', 'Պրովայդեր'), 0 => Yii::t('app', 'Պրովայդեր չէ')],
            'value' => function ($model) {
                return "<div class='text-center'>{$model::YES_OR_NO[$model->is_provider]}</div>";
            }
        ],
        [
            'attribute' => 'user_type',
            'label' => 'Ֆիզ. անձ / Կազ.',
            'value' => function ($model) {
                return $model::USER_TYPE[$model->user_type];
            }
        ],
        [
            'attribute' => 'crm_contact_id',
            'label' => 'Ֆիզ. անձ',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'name' => 'crm_contact_id',
                'attribute' => 'crm_contact_id',
                'initValueText' => Deal::getFilteredContactFullName(ArrayHelper::getValue(Yii::$app->getRequest()->getQueryParam('DealSearch'), 'crm_contact_id')), # Kartik Select2 GridView filter name instead of id
                'options' => [
                    'id' => 'choose-physical-person',
                    'placeholder' => 'Ընտրել Ֆիզ. անձ'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/fastnet/deal/search-physical-person']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(person) { console.log(person); return person.text; }'),
                    'templateSelection' => new JsExpression('function (person) { return person.text; }'),
                ],
            ]),
            'value' => function ($model) {
                return $model->crmContact->name.' '.$model->crmContact->surname;
            }
        ],
        [
            'attribute' => 'crm_company_id',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'name' => 'crm_company_id',
                'attribute' => 'crm_company_id',
                'initValueText' => Deal::getFilteredCompanyName(ArrayHelper::getValue(Yii::$app->getRequest()->getQueryParam('DealSearch'), 'crm_company_id')),
                'options' => [
                    'id' => 'choose-company',
                    'placeholder' => 'Ընտրել Կազմակերպություն'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/fastnet/deal/search-company']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(company) { console.log(company); return company.text; }'),
                    'templateSelection' => new JsExpression('function (company) { return company.text; }'),
                ],
            ]),
            'value' => function ($model) {
                return $model->crmCompany->name;
            }
        ],
        [
            'attribute' => 'address',
            'label' => 'Հասցե',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->formatedAddress();
            }
        ],
        [
            'attribute' => 'connect_id',
            'label' => 'Ծառ. / Փաթեթ',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'name' => 'connect_id',
                'attribute' => 'connect_id',
                'initValueText' => Deal::getFilteredTariff(ArrayHelper::getValue(Yii::$app->getRequest()->getQueryParam('DealSearch'), 'connect_id')),
                'options' => [
                    'id' => 'choose-tariff',
                    'placeholder' => 'Ծառ. / Փաթեթ'
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                    'minimumInputLength' => 3,
                    'language' => [
                        'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                    ],
                    'ajax' => [
                        'url' => Url::to(['/fastnet/deal/search-deal']),
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                    ],
                    'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'templateResult' => new JsExpression('function(city) { console.log(city); return city.text; }'),
                    'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                ],
            ]),
            'value' => function ($model) {
                return $model->tariff->name;
            }
        ],
        [
            'attribute' => 'base_station_id',
            'label' => 'Բազ. կայան',
            'filter' => Select2::widget([
                'model' => $searchModel,
                'name' => 'base_station_id',
                'attribute' => 'base_station_id',
                'data' => ArrayHelper::map(\app\modules\fastnet\models\BaseStation::find()->asArray()->all(), 'id', 'name'),
                'options' => [
                    'id' => 'choose-base-station',
                    'placeholder' => 'Ընտրել Բազ. կայան'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]),
            'value' => function ($model) {
                return $model->station->name;
            }
        ],
        [
            'attribute' => 'start_day',
            'filter' => DateRangePicker::widget([
                'model' => $searchModel,
                'attribute' => 'start_day',
                'convertFormat' => true,
                'includeMonthsFilter' => true,
                'presetDropdown' => true,
                'pluginOptions' => [
                    'locale' => [
                        'format' => 'd-m-Y'
                    ]
                ]
            ]),
            'format' => 'raw',
            'value' => function ($model) {
                return Helper::formatDate($model->connection_day, false, true);
            }
        ],
        [
            'attribute' => 'ip_count',
            'label' => 'IP ք․',
            'value' => function ($model) {
                return $model->getDealIpPriceByCount($model->deal_number) / 1000;
            }
        ],
        [
            'attribute' => 'monthly_pay',
            'label' => 'Ամս. վճար',
            'format' => 'html',
            'value' => function ($model) {
                $pricing = new Pricing($model);
                return $pricing->totalDealAmount() + $pricing->sumIPPrice();
            }
        ],
        [
            'attribute' => 'amount',
            'visible' => true,
            'value' => function ($model) {
                $ip_count_price = $model->getDealIpPriceByCount($model->deal_number);
                return ($model->tariff->inet_price ? $model->tariff->inet_price : 0) + ($model->tariff->tv ? $model->tariff->tv->price : 0) + $ip_count_price;
            }
        ],
        [
            'attribute' => 'penalty',
            'value' => function($model) {
                return $model->penalty ? Helper::removeUselessZeroDigits($model->penalty) : 0;
            }
        ],
        [
            'attribute' => 'electricity',
            'value' => function($model) {
                return $model->electricity ? Helper::removeUselessZeroDigits($model->electricity) : 0;
            }
        ],
        [
            'attribute' => 'discount',
            'value' => function($model) {
                return $model->discount ? Helper::removeUselessZeroDigits($model->discount) : 0;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Հղում',
            'template' => '{view}{update}{delete}',
            'buttons' => [
                'view' => function ($url, $model) {
                    if (Yii::$app->user->can('viewDeal', ['model' => $model])) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    }
                },
                'update' => function ($url, $model) {
                    if (Yii::$app->user->can('updateDeal', ['model' => $model]) && !$model->isTermination()) {
                        return
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Թարմացնել'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]);
                    }
                },
                'delete' => function ($url, $model) {
                    if (Yii::$app->user->can('deleteDeal', ['model' => $model])) {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջբջել'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                'method' => 'post',
                            ],
                        ]);
                    }
                }

            ]
        ]
    ];

    $dynagrid = DynaGrid::begin([
        'columns' => $columns,
        'showPersonalize' => true,
        'storage' => DynaGrid::TYPE_DB,
        'gridOptions' => [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'showPageSummary' => true,
            'floatHeader' => false,
//            'pjax' => true,
            'responsiveWrap' => true,
            'toolbar' =>  [
//                ['content' => '{dynagridFilter}{dynagridSort}{dynagrid}'],
                ['content' => '{dynagrid}'],
                '{export}' . ' ' .
                Helper::importForm()
//                Html::button(Yii::t('app', 'Ներմուծում'), [
//                    'type' => 'button',
//                    'title' => Yii::t('app', 'Ներմուծում'),
//                    'class' => 'btn btn-primary ml-2'
//                ]),
            ]
        ],
        'options' => [
            'id' => 'dynagrid-1' // a unique identifier is important
        ]
    ]);

    if (substr($dynagrid->theme, 0, 6) == 'simple') {
        $dynagrid->gridOptions['panel'] = false;
    }

    DynaGrid::end();
    ?>

</div>
