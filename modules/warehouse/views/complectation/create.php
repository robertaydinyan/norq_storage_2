<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */
/* @var $model_products app\modules\warehouse\models\ComplectationProducts */
/* @var $dataWarehouses app\modules\warehouse\models\Warehouse */

$this->title = array(Yii::t('app', 'Create Composition'),'Create Composition');


$this->params['breadcrumbs'][] = ['label' => 'Complectations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding: 20px;">

    <?= $this->render('_form', [
        'model' => $model,
        'model_products' => $model_products,
        'dataWarehouses' => $dataWarehouses,
    ]) ?>
    </div>
</div>
