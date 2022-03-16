<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ShippingProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ապրանքի տեղափոխություն';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('shipping-product', 'index')): ?>
<div class="shipping-product-index group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <?php if(\app\rbac\WarehouseRule::can('shipping-product', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-primary" >Ստեղծել Ապրանքի տեղափոխություն</a>
        <?php endif; ?>
    </h4>
    <div style="padding:20px;">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'providerWarehouse',
                'label' => 'Առաքող պահեստ',
                'value' => function ($model) {
                    return $model->shipping->fromWarehouse->name;
                }
            ],
            [
                'attribute' => 'supplierWarehouse',
                'label' => 'Ստացող պահեստ',
                'value' => function ($model) {
                    return $model->shipping->toWarehouse->name;
                }
            ],
            [
                'attribute' => 'name',
                'label' => 'Անուն',
                'value' => function ($model) {
                    return $model->product->nProduct->name;
                }
            ],
            [
                'attribute' => 'mac_address',
                'label' => 'Mac հասցե',
                'value' => function ($model) {
                    return $model->product->mac_address;
                }
            ],
            [
                'attribute' => 'count',
                'label' => 'Քանակ',
                'value' => function ($model) {
                    return $model->count;
                }
            ],
            [
                'label' => 'Ստեղծվել է',
                'value' => function ($model) {
                    return $model->created_at;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('shipping-product', 'view') ?
                            Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]) : '';
                    },

//                    'update' => function ($url, $model) {
//                        return
//                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
//                                'title' => Yii::t('app', 'Թարմացնել'),
//                                'class' => 'btn text-primary btn-sm mr-2'
//                            ]);
//                    },
//                    'delete' => function ($url, $model) {
//                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
//                            'title' => Yii::t('app', 'Ջբջել'),
//                            'class' => 'btn text-danger btn-sm',
//                            'data' => [
//                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
//                                'method' => 'post',
//                            ],
//                        ]);
//                    }

                ]
            ],
        ],
    ]); ?>

    </div>
</div>
<?php  endif; ?>
