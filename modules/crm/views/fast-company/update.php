<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\crm\models\Company */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $companyDocument app\modules\crm\models\CompanyDocument */

$this->title = 'Թարմացնել կազմակերպությունը: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-update card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address,
        'companyDocument' => $companyDocument,
    ]) ?>

</div>
