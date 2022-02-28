<?php

use Carbon\Carbon;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\crm\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Կազմակերպություն';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <div class="card card-body border-0 shadow rounded mt-3">
        <div class="d-flex align-items-center justify-content-between">
            <h1><?= Html::encode($this->title) ?></h1>

                <?= Html::a('Ավելացնել Կազմակերպություն', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'name',
                        'value' => function ($model) {
                            return $model->name;
                        },
                    ],
                    [
                        'attribute' => 'phone',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $phones = [];

                            if ($model->companyPhone) {
                                foreach ($model->companyPhone as $phone) {
                                    $phones[] = $phone->phone;
                                }
                            }

                            return Html::tag('div', StringHelper::truncate(implode(",<br>", $phones), 29), ['title' => implode(", ", $phones), 'data-toggle' => 'tooltip', 'data-placement' => 'top']);
                        },
                    ],
                    'email:email',
                    'passport_number',
                    [
                        'attribute' => 'address',
                        'label' => 'Հասցե',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->formatedAddress();
                        }
                    ],
                    [
                        'attribute' => 'passportImage',
                        'label' => 'Կազմակերպության փաստաթուղթ',
                        'format' => 'html',
                        'value' => function ($model) {
                            if ($model->requisiteFiles[0]['image']) {
                                return Html::img(Yii::getAlias('@web').'/company_document/'. $model->requisiteFiles[0]["image"],
                                    ['width' => '70px']);
                            }
                        },
                    ],
                    [
                        'attribute' => 'create_at',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'create_at',
                            'convertFormat' => true,
                            'includeMonthsFilter' => true,
                            'presetDropdown' => true,
                            'pluginOptions' => [
                                'locale' => [
                                    'format' => 'd-m-Y'
                                ]
                            ]
                        ]),
                        'value' => function ($model) {
                            return Carbon::parse($model->create_at)->format('d-m-Y H:i');
                        },
                    ],
                    [
                        'attribute' => 'update_at',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'update_at',
                            'convertFormat' => true,
                            'includeMonthsFilter' => true,
                            'presetDropdown' => true,
                            'pluginOptions' => [
                                'locale' => [
                                    'format' => 'd-m-Y'
                                ]
                            ]
                        ]),
                        'value' => function ($model) {
                            return Carbon::parse($model->update_at)->format('d-m-Y H:i');
                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Հղում',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                    return
                                        Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                            'title' => Yii::t('app', 'Թարմացնել'),
                                            'class' => 'btn text-primary btn-sm mr-2'
                                        ]);
                            },
                            'delete' => function ($url, $model) {
                                    return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                                        'title' => Yii::t('app', 'Ջբջել'),
                                        'class' => 'btn text-danger btn-sm',
                                        'data' => [
                                            'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                            'method' => 'post',
                                        ],
                                    ]);
                            }

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>

</div>
