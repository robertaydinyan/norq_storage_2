<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\PartnersList */

$this->title = 'Update Partners List: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Partners Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="partners-list-update">

    <h1><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
