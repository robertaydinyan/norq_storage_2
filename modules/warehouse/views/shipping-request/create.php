<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
/* @var $dataWarehouses app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\ShippingRequest */
/* @var $dataUsers app\modules\warehouse\models\ShippingRequest */
/* @var $suppliers app\modules\warehouse\models\ShippingType */
/* @var $types app\modules\warehouse\models\ShippingType */
/* @var $partners app\modules\warehouse\models\PartnersList */
$this->title = Yii::t('app', 'Create a query');
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-request-create group-product-index">
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
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
