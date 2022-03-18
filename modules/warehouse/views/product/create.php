<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Product */
/* @var $nProducts app\modules\warehouse\models\Product */
/* @var $physicalWarehouse app\modules\warehouse\models\Product */
/* @var $modelNProduct app\modules\warehouse\models\Product */
/* @var $groupProducts app\modules\warehouse\models\Product */
/* @var $qtyTypes app\modules\warehouse\models\Product */
/* @var $tableTreeGroups app\modules\warehouse\models\Product */

$this->title = 'Ստեղծել Ապրանք';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h4>
    <div style="padding:20px;" >
    <?= $this->render('_form', [
        'model' => $model,
        'nProducts' => $nProducts,
        'physicalWarehouse' => $physicalWarehouse,
        'suppliers' => $suppliers,
//        'modelNProduct' => $modelNProduct,
//        'groupProducts' => $groupProducts,
//        'qtyTypes' => $qtyTypes,
//        'tableTreeGroups'=> $tableTreeGroups,
    ]) ?>
    </div>
</div>
