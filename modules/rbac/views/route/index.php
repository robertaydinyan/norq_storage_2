<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\modules\rbac\RbacRouteAsset;

RbacRouteAsset::register($this);

/* @var $this yii\web\View */
/* @var $routes array */

$this->title = Yii::t('app', 'Routes');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="route-index card card-body border-0 shadow rounded mt-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3><?php echo Html::encode($this->title); ?></h3>
        <?php echo Html::a(Yii::t('app', 'Refresh'), ['refresh'], [
            'class' => 'btn btn-primary',
            'id' => 'btn-refresh',
        ]); ?>
    </div>

    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $routes,
        ]),
        'assignUrl' => ['assign'],
        'removeUrl' => ['remove'],
    ]); ?>
</div>
