<?php

use yii\helpers\Html;
use yii\helpers\Json;
use app\modules\rbac\RbacAsset;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AssignmentModel */
/* @var $usernameField string */

$userName = $model->user->{$usernameField};
$this->title = Yii::t('app', 'Assignment : {0}', $userName);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $userName;
?>
<div class="assignment-index card card-body border-0 shadow rounded mt-3">

    <h3 class="mb-4"><?php echo Html::encode($this->title); ?></h3>

    <?php echo $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
        ]),
        'assignUrl' => ['assign', 'id' => $model->userId],
        'removeUrl' => ['remove', 'id' => $model->userId],
    ]); ?>

</div>
