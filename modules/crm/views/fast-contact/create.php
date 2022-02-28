<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\crm\models\Contact */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $contactPassport app\modules\crm\models\ContactPassport */

$this->title = 'Ստեղծել Ֆիզիկական անձ';
$this->params['breadcrumbs'][] = ['label' => 'Contacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-create card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'contactPassport' => $contactPassport,
        'address' => $address,
    ]) ?>

</div>
