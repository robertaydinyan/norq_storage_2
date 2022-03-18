<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationProducts */

$this->title = 'Update Complectation Products: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complectation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="complectation-products-update">

    <h1><?= Html::encode($this->title) ?><span class="star" ><i class="fa fa-star-o ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
