<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\crm\models\Company */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $companyDocument app\modules\crm\models\CompanyDocument */
/* @var $phone app\modules\crm\models\ContactPhone */

$this->title = 'Ստեղծել կազմակերպություն';
$this->params['breadcrumbs'][] = ['label' => 'Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address,
        'companyDocument' => $companyDocument,
        'phone' => $phone
    ]) ?>

</div>
