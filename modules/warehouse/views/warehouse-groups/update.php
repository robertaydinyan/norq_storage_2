<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\WarehouseGroups */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

$this->title = Yii::t('app', 'Update') . ': ' . $model->{'name_' . $lang};
$this->params['breadcrumbs'][] = ['label' => 'Warehouse Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . $lang}, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
