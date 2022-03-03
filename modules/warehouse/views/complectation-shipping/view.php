<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationShipping */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complectation Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="complectation-shipping-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover'],
        'attributes' => [
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
    ]) ?>

</div>
