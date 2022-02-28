<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\PartnersList */

$this->title = 'Create Partners List';
$this->params['breadcrumbs'][] = ['label' => 'Partners Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
