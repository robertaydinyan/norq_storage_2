<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\GroupProduct */
/* @var $groupProducts app\modules\warehouse\models\GroupProduct */

$this->title = 'Ստեղծել Ապրանքի խումբ';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = ['label' => 'Group Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts
    ]) ?>

</div>
