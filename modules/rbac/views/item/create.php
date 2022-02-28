<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItemModel */

//$labels = $this->context->getLabels();
//$this->title = Yii::t('app', 'Create ' . $labels['Item']);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->title = Yii::t('app', 'Create Item');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-create card card-body border-0 shadow rounded mt-3">
    <h3 class="mb-4"><?= Html::encode($this->title); ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>