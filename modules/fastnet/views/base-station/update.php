<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\BaseStation */
/* @var $isset_equipments app\modules\fastnet\models\BazeStationEquipments */
/* @var $equipments app\modules\fastnet\models\BazeStationEquipments */

$this->title = 'Փոփոխել բազային կայանը: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Բազային կայաններ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Փոփոխել';
?>
<div class="base-station-update card card-body border-0 shadow rounded">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'isset_equipments' => $isset_equipments,
        'equipments' => $equipments,
    ]) ?>

</div>
