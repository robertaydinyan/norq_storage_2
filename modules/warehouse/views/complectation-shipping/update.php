<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationShipping */

$this->title = 'Update Complectation Shipping: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complectation Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="complectation-shipping-update group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
