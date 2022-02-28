<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItemModel */

$context = $this->context;
//$labels = $this->context->getLabels();
//$this->title = Yii::t('app', 'Update ' . $labels['Item'] . ' : {0}', $model->name);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="auth-item-update card card-body border-0 shadow rounded mt-3">

    <h3 class="mb-4"><?= Html::encode($this->title); ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>