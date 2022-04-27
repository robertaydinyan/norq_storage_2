<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchStatusList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Statuses'),'Statuses');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<?php if(\app\rbac\WarehouseRule::can('status-list', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
    <?php if(\app\rbac\WarehouseRule::can('status-list', 'create')): ?>
        <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary float-right']) ?>
    <?php endif; ?>
    </h1>

    <div style="padding: 20px;">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name_' . $lang,
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('status-list', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    }

                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
</div>
<?php endif; ?>