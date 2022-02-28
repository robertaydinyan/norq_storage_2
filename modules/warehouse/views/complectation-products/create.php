<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationProducts */

$this->title = 'Create Complectation Products';
$this->params['breadcrumbs'][] = ['label' => 'Complectation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complectation-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
