<?php

use app\modules\billing\models\Cities;
use app\modules\billing\models\Community;
use app\modules\billing\models\Countries;
use app\modules\billing\models\Regions;
use app\modules\crm\models\ContactPhone;
use Carbon\Carbon;
use kartik\daterange\DateRangePicker;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\crm\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ֆիզ․ անձ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-index ">

    <div class="card card-body border-0 shadow rounded mt-3 ">
        <div class="d-flex align-items-center justify-content-between">
            <h1><?= Html::encode($this->title) ?></h1>

                <?= Html::a('Ավելացնել Ֆիզ․ անձ', ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="table-responsive">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'name',
                        'label' => 'Ա․Ա․Հ․',
                        'value' => function ($model) {
                            return $model->name . ' ' . $model->surname . ' ' . $model->middle_name;
                        },
                    ],
                    [
                        'attribute' => 'dob',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'dob',
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
                            return !empty($model->dob) ? Carbon::parse($model->dob)->format('d-m-Y') : null;
                        },
                    ],
                    'passport_number',
                    'visible_by',
                    [
                        'attribute' => 'when_visible',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'when_visible',
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
                            return !empty($model->when_visible) ? Carbon::parse($model->when_visible)->format('d-m-Y') : null;
                        },
                    ],
                    [
                        'attribute' => 'valid_until',
                        'filter' => DateRangePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'valid_until',
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
                            return !empty($model->valid_until) ? Carbon::parse($model->valid_until)->format('d-m-Y') : null;
                        },
                    ],
                    'email',
                    [
                        'attribute' => 'phone',
                        'label' => 'Հ․Հ․',
                        'format' => 'html',
                        'value' => function ($model) {
                            $phones = [];

                            if(!empty($model->contactPhone)) {
                                foreach ($model->contactPhone as $key => $phone){
                                    $phones[] = $phone->phone;
                                }
                            }

                            return Html::tag('div', StringHelper::truncate(implode(',<br> ', $phones), 100), ['title' => implode(', ', $phones)]);
                        },
                    ],
                    [
                        'attribute' => 'passportImage',
                        'label' => 'Անձնագրի նկար',
                        'format' => 'html',
                        'value' => function ($model) {
                           if ($model->requisiteFiles[0]['image']) {
                               return Html::img(Yii::getAlias('@web').'/contact_passport/'. $model->requisiteFiles[0]["image"],
                                   ['width' => '70px']);
                           }
                        },
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
