<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\fastnet\models\BaseStationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Բազային կայաններ';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .table {
        color: #000;
    }
</style>
    <div class="base-station-index card card-body border-0 shadow rounded mt-3">
        <div class="d-flex align-items-center justify-content-between">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a(Yii::t('app', 'Ստեղծել բազային կայան'), ['create'], ['class' => 'btn btn-primary']) ?>
        </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                'ip',
                'ip_end',
                [
                    'attribute'=>'zona_id',
                    'value'=>function($model) {
                        return implode(', ', $model->selectedZoneName());
                    }
                ],
                [
                    'attribute'=>'equipment_id',
                    'value'=>function($model) {
                        return $model->equipments;
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Հղում',
                    'template' => '{update}{delete}',
                    'buttons' => [
    //                    'view' => function ($url, $model) {
    //                        return Html::a('<i class="far fa-eye"></i>', $url, [
    //                            'title' => Yii::t('app', 'Դիտել'),
    //                            'class' => 'btn text-primary btn-sm mr-2'
    //                        ]);
    //                    },

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
