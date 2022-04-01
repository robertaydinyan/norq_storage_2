<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Analogs */

$this->title = array(Yii::t('app', 'Update an analog'),'Update an analog');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index form-data">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <div style="padding: 20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'nomiclatures'=>$nomiclatures,
        'type' => 'update'
    ]) ?>
    </div>
</div>
