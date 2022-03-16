<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchWarehouseTypes */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Warehouse types');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<?php if(\app\rbac\WarehouseRule::can('warehouse-types', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?>
    <?php if(\app\rbac\WarehouseRule::can('warehouse-types', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn  btn-primary" ><?php echo Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Type'); ?></a>
    <?php endif; ?>
    </h1>
    <div style="padding:20px;">
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
                        return
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]);
                    }

                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
</div>
<?php endif; ?>