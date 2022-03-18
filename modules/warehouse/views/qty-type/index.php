<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\QtyTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$lang = explode('-', \Yii::$app->language)[0];
$lang = $lang ?: 'us';
$this->title = Yii::t('app', 'Unit of measurement');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('qty-type', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;" ><?= Html::encode($this->title) ?><span class="star" ><i class="fa fa-star-o ml-4"></i></span>
        <?php if(\app\rbac\WarehouseRule::can('qty-type', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create' ,'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create a unit of measurement'); ?></a>
        <?php endif; ?>
    </h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="padding: 20px;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'header' => Yii::t('app', 'Unit of measurement'),
                'attribute' => 'type_' . $lang
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Reference'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language , [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'delete') ?
                            Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
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
</div>
<?php endif; ?>
