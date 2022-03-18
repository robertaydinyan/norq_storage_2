<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $groupProducts app\modules\warehouse\models\NomenclatureProduct */
/* @var $qtyTypes app\modules\warehouse\models\NomenclatureProduct */
/* @var $tableTreeGroups app\modules\warehouse\models\NomenclatureProduct */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

$this->title = ': ' . $model->{'name_' . $lang};
$this->params['breadcrumbs'][] = ['label' => 'Nomenclature Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{'name_' . $lang}, 'url' => ['view', 'id' => $model->id]];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nomenclature-product-update group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h4>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts,
        'tableTreeGroups'=> $tableTreeGroups,
        'qtyTypes' => $qtyTypes
    ]) ?>
    </div>
</div>
