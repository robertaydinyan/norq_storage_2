<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Shipping */
/* @var $searchModel app\modules\warehouse\models\ShippingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="shipping-view group-product-index" style="padding: 20px;">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a  href="/warehouse/shipping">Տեղափոխություն</a></li>
            <li class="breadcrumb-item "><a  href="#"><?php echo $model->shipping_type;?> (<?= Html::encode($this->title) ?>)</a></li>
        </ol>
    </nav>

    <div class="col-lg-4">
        <h4 ><?php echo $model->shipping_type;?> (<?= Html::encode($this->title) ?>)<span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h4>

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-hover'],
            'attributes' => [
                'id',
                [
                    'label' => 'Ստեղծվել է',
                    'value' => $model->created_at
                ],
                [
                    'label' => 'Տեղափոխման տեսակ',
                    'value' => $model->shipping_type
                ],
                [
                    'label' => 'Առաքող պահեստ',
                    'value' => function ($model) {
                        return $model->toWarehouse->name;
                    }
                ],
                [
                    'label' => 'Ստացող պահեստ',
                    'value' => function ($model) {
                        return $model->fromWarehouse->name;
                    }
                ],
                [
                    'label' => 'Կարգավիճակ',
                    'value' => $model->status
                ],

            ],
        ]) ?>
        <p>
            <?= Html::a('Փոփոխել', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>

    <div class="col-lg-8">
        <?php if ($model->status === 'Ուղղարկված'|| $model->status == 'Հաստատված' ) : ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
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

                ],
            ]); ?>
<!--            $model->toWarehouse->user_id === Yii::$app->user->identity->id-->
            <?php if ($model->status !== 'Հաստատված') : ?>
                <div>
                    <a href="<?= Url::to(['shipping/confirm-shipping', 'shippingId' => $model->id]) ?>"  class="btn btn-primary" >Տեղափոխության հաստատում</a>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <?php if ($model->status === 'Հարցված' || $model->status === 'Հաստատված հարցում') : ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    [
                        'attribute' => 'nProductName',
                        'label' => 'Անուն',
                        'value' => function ($model) {
                            return $model->nProduct->name;
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
                        'attribute' => 'qty_type',
                        'label' => 'Քանակի տեսակը',
                        'value' => function ($model) {
                            return $model->nProduct->qtyType->type;
                        }
                    ],

                ],
            ]); ?>
            <?php if ($model->status !== 'Հաստատված հարցում') : ?>
                <div style="display: flex">
                    <div class="col-lg-6">
                        <a href="<?= Url::to(['shipping/edit-shipping-request', 'shippingId' => $model->id]) ?>"  class="btn btn-primary" >Հարցման փոփոխում</a>
                    </div>

                    <div class="col-lg-6">
                        <a href="<?= Url::to(['shipping/confirm-shipping-request', 'shippingId' => $model->id]) ?>"  class="btn btn-primary" >Հարցման հաստատում</a>
                    </div>
                </div>
            <?php elseif ($model->status == 'Հաստատված հարցում') : ?>
                    <div style="display: flex">
                        <div class="col-lg-6">
                            <a href="<?= Url::to(['shipping-product/create', 'shippingId' => $model->id]) ?>"  class="btn btn-primary" >Կատարել տեղափոխություն</a>
                        </div>
                    </div>

            <?php endif; ?>


        <?php endif; ?>
    </div>





</div>
