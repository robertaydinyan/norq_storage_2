<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\SuppliersList */

$this->title = Yii::t('app', 'Create a provider');
$this->params['breadcrumbs'][] = ['label' => 'Suppliers Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h4>
    <div style="padding:20px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
