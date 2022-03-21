<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\GroupProduct */
/* @var $groupProducts app\modules\warehouse\models\GroupProduct */

$this->title = array( Yii::t('app', 'Create a Product Group'),'Create a Product Group');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = ['label' => 'Group Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="group-product-index">

    <h1 style="padding: 20px;"  data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts
    ]) ?>

</div>
