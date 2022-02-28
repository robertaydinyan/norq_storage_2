<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('app', 'Update Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rule-item-update card card-body border-0 shadow rounded mt-3">

    <h3 class="mb-4"><?php echo Html::encode($this->title); ?></h3>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>
</div>