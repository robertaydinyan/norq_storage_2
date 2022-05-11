<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Vat */

$this->title = array('Թարմացնել ԱԱՀ: ' . $model->name, 'Թարմացնել ԱԱՀ: ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Vats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vat-update">

    <h1><?= Html::encode($this->title[1]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
