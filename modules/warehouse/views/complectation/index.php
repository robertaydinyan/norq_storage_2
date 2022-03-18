<?php

use app\components\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Composition');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('complectation', 'index')): ?>
<div class="group-product-index">

    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa fa-star-o ml-4"></i></span>
    <?php if(\app\rbac\WarehouseRule::can('complectation', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Composition'); ?></a>
    <?php endif; ?>
    </h1>

    <?php Pjax::begin(); ?>
    <div style="padding:20px;" >
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id',
            'price',
            'name',
            'count',
            'created_at',
            //'warehouse_id',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '{view}{delete}',
                'buttons' => [

                    'view' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('complectation', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . \Yii::$app->language, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('complectation', 'delete') ? Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                'method' => 'post',
                            ],
                        ]) : '';
                    }

                ]
            ],
        ],
    ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>
<?php endif; ?>