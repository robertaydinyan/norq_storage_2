<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Տեղափոխություն';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">

    <h4 style="padding: 20px;">
        <?= Html::encode($this->title) ?>
        <div style="display: flex;float: right">
            <a style="margin-right: 10px;" href="<?= Url::to(['/warehouse/shipping-product']) ?>"  class="btn btn-sm btn-success" >Ապրանքի տեղափոխություն</a>
        </div>
    </h4>

    <div style="padding:20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'created_at',
            'shipping_type',
            [
                'attribute' => 'provider_warehouse_id',
                'label' => 'Առաքող պահեստ',
                'value' => function ($model) {
                    return $model->fromWarehouse->name;
                }
            ],
            [
                'attribute' => 'supplier_warehouse_id',
                'label' => 'Ստացող պահեստ',
                'value' => function ($model) {
                    return $model->toWarehouse->name;
                }
            ],
            'status',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="far fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    },

                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջնջել'),
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
