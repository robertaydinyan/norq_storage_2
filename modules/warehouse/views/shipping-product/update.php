<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingProduct */

$this->title = 'Փոփոխել Ապրանքի տեղափոխություն: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shipping-product-update">

    <h1><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
