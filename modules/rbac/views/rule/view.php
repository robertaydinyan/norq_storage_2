<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\BizRuleModel */

$this->title = Yii::t('app', 'Rule : {0}', $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="rule-item-view card card-body border-0 shadow rounded mt-3">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3><?php echo Html::encode($this->title); ?></h3>

        <div>
            <?php echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
            <?php echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->name], [
                'class' => 'btn btn-danger',
                'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                'data-method' => 'post',
            ]); ?>
        </div>
    </div>

    <?php echo DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover'],
        'attributes' => [
            'name',
            'className',
        ],
    ]); ?>

</div>
