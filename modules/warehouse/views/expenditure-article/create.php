<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ExpenditureArticle */

$this->title = array('Ստեղծել ծախսային հոդված', 'Ստեղծել ծախսային հոդված');
$this->params['breadcrumbs'][] = ['label' => 'Expenditure Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="expenditure-article-create">

    <h1><?= Html::encode($this->title[1]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
