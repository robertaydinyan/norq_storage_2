<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
/* @var $dataWarehouses app\modules\warehouse\models\ShippingRequest */
/* @var $dataUsers app\modules\warehouse\models\ShippingRequest */
/* @var $types app\modules\warehouse\models\ShippingRequest */
/* @var $suppliers app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\ShippingRequest */
/* @var $partners app\modules\warehouse\models\PartnersList */
$this->title = 'Տեփոխության հարցում: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-request-create group-product-index">

    <h5 style="padding: 20px;"><?= Html::encode($this->title) ?></h5>
    <div style="padding:20px;">
        <?= $this->render('_form', [
            'model' => $model,
            'dataWarehouses' => $dataWarehouses,
            'dataUsers'=>$dataUsers,
            'types' => $types,
            'requests'=> $requests,
            'suppliers' => $suppliers,
            'partners' => $partners,
            'nProducts' => $nProducts
        ]) ?>
    </div>
</div>
