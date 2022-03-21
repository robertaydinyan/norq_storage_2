<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationShipping */

$this->title = array($model->id);
$this->params['breadcrumbs'][] = ['label' => 'Complectation Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
?>
<div class="complectation-shipping-view">

    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

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
