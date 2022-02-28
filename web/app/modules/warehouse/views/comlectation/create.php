<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Comlectation */

$this->title = Yii::t('app', 'Create Comlectation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Comlectations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comlectation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
