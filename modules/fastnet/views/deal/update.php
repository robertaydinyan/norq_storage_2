<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\Deal */
/* @var $ipAddresses app\modules\fastnet\models\DealIp */

$this->title = 'Թարմացնել: ' . $model->deal_number;
$this->params['breadcrumbs'][] = ['label' => 'Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deal-update card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ipAddresses' => $ipAddresses
    ]) ?>

</div>
