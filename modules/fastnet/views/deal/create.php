<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\fastnet\models\Deal */
/* @var $nProducts app\modules\fastnet\models\Deal */
/* @var $shipping app\modules\fastnet\models\Deal */
/* @var $baseStationWarehouse app\modules\fastnet\models\Deal */
/* @var $nProduct app\modules\fastnet\models\Deal */
/* @var $shippingProduct app\modules\fastnet\models\Deal */
/* @var $baseWarehouse app\modules\fastnet\models\Deal */
/* @var $crmContact app\modules\crm\models\Contact */
/* @var $crmCompany app\modules\crm\models\Company */
/* @var $address app\modules\crm\models\ContactAdress */
/* @var $contactPassport app\modules\crm\models\ContactPassport */
/* @var $antennaIp app\modules\billing\models\AntennaIp */

$this->title = 'Ստեղծել Գործարք';
$this->params['breadcrumbs'][] = ['label' => 'Deals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deal-create card card-body border-0 shadow rounded mt-3">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'crmContact' => $crmContact,
        'crmCompany' => $crmCompany,
        'address' => $address,
        'contactPassport' => $contactPassport,
        'antennaIp' => $antennaIp,
        'nProducts' => $nProducts,
        'shipping' => $shipping,
        'baseStationWarehouse' => $baseStationWarehouse,
        'nProduct' => $nProduct,
        'baseWarehouse' => $baseWarehouse,
        'shippingProduct' => $shippingProduct,
    ]) ?>

</div>