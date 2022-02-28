<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\BaseStation */
/* @var $equipments app\modules\fastnet\models\BazeStationEquipments */

$this->title = 'Ստեղծել բազային կայան';
$this->params['breadcrumbs'][] = ['label' => 'Բազային կայաններ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-station-create card card-body border-0 shadow rounded">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'equipments' => $equipments,
    ]) ?>

</div>
