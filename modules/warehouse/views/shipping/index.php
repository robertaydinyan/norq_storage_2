<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = array(Yii::t('app', 'Տեղափոխություն'),'Տեղափոխություն');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title[0];
?>
<?php if(\app\rbac\WarehouseRule::can('shipping', 'index')): ?>
<div class="group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>">
        <?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
        <div style="display: flex;float: right">
    <?php if(\app\rbac\WarehouseRule::can('shipping', 'edit-shipping-request')): ?>
            <a style="margin-right: 10px;" href="<?= Url::to(['/warehouse/shipping-product']) ?>"  class="btn  btn-primary" >Ապրանքի տեղափոխություն</a>
    <?php endif; ?>
        </div>
    </h1>

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
                        return \app\rbac\WarehouseRule::can('shipping', 'view') ?
                            Html::a('<i class="fas fa-eye"></i>', $url, [
                            'title' => Yii::t('app', 'Դիտել'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]) : '';
                    },

                    'delete' => function ($url, $model) {
                        return  \app\rbac\WarehouseRule::can('shipping', 'delete') ?
                            Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջնջել'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
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