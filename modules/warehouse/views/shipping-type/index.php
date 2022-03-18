<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchShippingType */
/* @var $dataProvider yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

$this->title = Yii::t('app', 'Type of transfer');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('shipping-type', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
    <?php if(\app\rbac\WarehouseRule::can('shipping-type', 'create')): ?>
        <?= Html::a(Yii::t('app', 'Create'), ['create', 'lang' => \Yii::$app->language], ['class' => 'btn btn-primary float-right']) ?>
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
                        return \app\rbac\WarehouseRule::can('shipping-type', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url .'&lang=' . \Yii::$app->language, [
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