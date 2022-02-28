<?php

use yii\helpers\Html;

/* @var $this  yii\web\View */
/* @var $model app\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('app', 'Create Rule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rule-item-create card card-body border-0 shadow rounded mt-3">

    <h3 class="mb-4"><?php echo Html::encode($this->title); ?></h3>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>