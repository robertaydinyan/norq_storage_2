<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureType */

$this->title = 'Create Nomenclature Type';
$this->params['breadcrumbs'][] = ['label' => 'Nomenclature Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nomenclature-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
