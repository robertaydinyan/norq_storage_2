<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\WarehouseTypes */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

$this->title =array(Yii::t('app', 'Warehouse type') . ' : ' .  $model->{'name_' . $lang}, 'Warehouse type');
$this->params['breadcrumbs'][] = ['label' => 'Պահեստի տեսակ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . $lang}, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =$this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
