<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ExpenditureArticle */

$this->title = array('Թարմացնել ծախսային հոդված: ' . $model->name, 'Թարմացնել ծախսային հոդված: ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => 'ծախսային հոդված', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="expenditure-article-update">

    <h1><?= Html::encode($this->title[0]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
