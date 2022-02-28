<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ComplectationShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Կոմպլեկտացիաի տեղափոխություն';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="complectation-shipping-index group-product-index" >

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել կոմպլեկտացիայի տեղափոխություն</a>
    </h4>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="padding: 20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'providerWarehouse',
                'label' => 'Առաքող պահեստ',
                'value' => function ($model) {
                    return $model->complectation->fromWarehouse->name;
                }
            ],
            [
                'attribute' => 'supplierWarehouse',
                'label' => 'Ստացող պահեստ',
                'value' => function ($model) {
                    return $model->complectation->toWarehouse->name;
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
                    return $model->n_product_count;
                }
            ],

        ],
    ]); ?>
    </div>

</div>
