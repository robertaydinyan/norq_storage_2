<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Vat */

$this->title = array('ԱԱՀ', 'ԱԱՀ');
$this->params['breadcrumbs'][] = ['label' => 'Vats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="vat-create">

    <h1><?= Html::encode($this->title[1]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
