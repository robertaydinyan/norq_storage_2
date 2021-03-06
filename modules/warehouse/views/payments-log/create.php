<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */
/* @var $tableTreePartners [] */
/* @var $currencies app\modules\warehouse\models\Currency[] */

$this->title = array(Yii::t('app', 'make a payment'),'make a payment');
$this->params['breadcrumbs'][] = ['label' => 'Qty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<div class="group-product-index form-data">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding: 20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'tableTreePartners'=> $tableTreePartners,
        'type' => 'create',
        'currencies' => $currencies
    ]) ?>
    </div>
</div>
