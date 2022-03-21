<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $dataUsers app\modules\warehouse\models\Warehouse */
/* @var $warehouse_types app\modules\warehouse\models\Warehouse */

$this->title = array(Yii::t('app', 'Change warehouse') . ' : ' . $model->id, 'Change warehouse' . ' : ' . $model->id);
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="warehouse-update group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'dataUsers'=>$dataUsers,
        'warehouse_types' => $warehouse_types
    ]) ?>
    </div>
</div>
