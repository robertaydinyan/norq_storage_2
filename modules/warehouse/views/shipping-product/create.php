<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
/* @var $shippingModel app\modules\warehouse\models\ShippingRequest */
/* @var $dataWarehouses app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\ShippingRequest */
/* @var $dataUsers app\modules\warehouse\models\ShippingRequest */
/* @var $searchModel app\modules\warehouse\models\ShippingRequest */
/* @var $dataProvider app\modules\warehouse\models\ShippingRequest */

$this->title = 'Ստեղծել Ապրանքի տեղափոխություն';
$this->params['breadcrumbs'][] = ['label' => 'Shipping Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-product-create group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'shippingModel' => $shippingModel,
       // 'modelNProduct' => $modelNProduct,
        'dataWarehouses' => $dataWarehouses,
        'dataUsers'=>$dataUsers,
        'nProducts' => $nProducts,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]) ?>
    </div>
</div>
