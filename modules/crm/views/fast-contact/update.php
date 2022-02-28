<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\crm\models\Contact */

$this->title = 'Ֆիզ․ անձի թարմացում: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="contact-update card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address,
        'contactPassport' => $contactPassport
    ]) ?>

</div>
