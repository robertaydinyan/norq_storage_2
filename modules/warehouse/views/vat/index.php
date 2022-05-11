<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isFavorite integer */

$this->title = array('ԱԱՀ', 'ԱԱՀ');
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="vat-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between mt-3 mb-3">
        <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>" >
            <?= Html::encode($this->title[0]) ?>
        </h1>
        <div>
            <a class="btn btn-primary" href="/warehouse/vat/create?show-header=true">Ստեղծել ԱԱՀ</a>
            <button onclick="tableToExcel('tbl','test','currency.xls')" class="btn btn-primary  mr-2">Xls</button>
        </div>
    </div>




    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id' => [
                'label' =>  Yii::t('app', 'ID'),
                'format' => 'html',
                'value' => function ($model) {
                    $isDeleted = $model->isDeleted;
                    if ($isDeleted == 1){
                        return $model->id . "<i class=\"fa fa-remove pl-3 text-danger\"></i>";

                    }else {
                        return  $model->id ;
                    }
                }
            ],
            'name',
            'formula',


            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Reference'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'delete') ?
                            Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn text-danger btn-sm',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                    'method' => 'post',
                                ],
                            ]) : '';
                    }

                ]
            ]
        ],
    ]); ?>


</div>
