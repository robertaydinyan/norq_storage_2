<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\StatusList */

$this->title = array(Yii::t('app', 'Create Status'),'Create Status');
$this->params['breadcrumbs'][] = ['label' => 'Status Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index form-data">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;" >


    <?= $this->render('_form', [
        'model' => $model,
        'type' => 'create'
    ]) ?>
    </div>
</div>
