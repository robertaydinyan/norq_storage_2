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
$this->title = array(Yii::t('app', 'In the matter of change') . ' : ' . $model->id, 'In the matter of change');
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =  $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-request-create group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
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
