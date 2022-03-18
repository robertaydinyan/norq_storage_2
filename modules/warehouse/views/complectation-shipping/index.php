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
<?php if(\app\rbac\WarehouseRule::can('complectation-shipping', 'index')): ?>
<div class="complectation-shipping-index group-product-index" >

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a>
        <?php if(\app\rbac\WarehouseRule::can('complectation-shipping', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-primary" >Ստեղծել կոմպլեկտացիայի տեղափոխություն</a>
        <?php endif; ?>
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

<?php endif; ?>
