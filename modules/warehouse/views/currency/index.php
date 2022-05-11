<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isFavorite boolean */

$this->title = array(Yii::t('app', 'Currencies'), 'Currencies');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(\app\rbac\WarehouseRule::can('currency', 'index')): ?>
    <div class="currency-index">
        <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between mt-3 mb-3">
        <h1  data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('currency', 'create')): ?>
                <?= Html::a(Yii::t('app', 'Create Currency'), ['create'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
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
                'symbol',
                'code',
                [
                    'label' => Yii::t('app', 'Value'),
                    'value' => function($model) {
                        return $model->getCurrencyValue($model->id);
                    }
                ],
                /*'isDeleted' => [
                    'label' =>  Yii::t('app', 'Status'),
                    'format' => 'html',
                    'value' => function ($model) {
                        $isDeleted = $model->isDeleted;
                        if ($isDeleted == 1){
                            return "<p class='text-center p-2 bg-danger w-50 text-white m-auto'>Deleted</p>";

                        }else {
                            return  "<p class='text-center p-2 bg-primary w-50 text-white m-auto'>Saved</p>";
                        }
                    }
                ],*/

                ['class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('currency', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . \Yii::$app->language, [
                                'title' => Yii::t('app', 'View'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                        },
                        'update' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('currency', 'update') ?
                                Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                                    'title' => Yii::t('app', 'Update'),
                                    'class' => 'btn text-primary btn-sm mr-2'
                                ]) : '';
                        },
                        'delete' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('currency', 'delete') ?
                                Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
                                    'title' => Yii::t('app', 'Delete'),
                                    'class' => 'btn text-danger btn-sm',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                        'method' => 'post',
                                    ],
                                ]) : '';
                        }
                    ]],
            ],
        ]); ?>


    </div>
<?php endif; ?>