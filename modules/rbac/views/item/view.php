<?php

use app\modules\rbac\RbacAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\DetailView;

RbacAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\rbac\models\AuthItemModel */

//$labels = $this->context->getLabels();
//$this->title = Yii::t('app', $labels['Item'] . ' : {0}', $model->name);
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $labels['Items']), 'url' => ['index']];
$this->title = Yii::t('app', 'Item' . ' : {0}', $model->name);
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="auth-item-view card card-body border-0 shadow rounded mt-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3><?= Html::encode($this->title); ?></h3>
        <div>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']); ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->name], [
                'class' => 'btn btn-danger',
                'data-confirm' => Yii::t('app', 'Are you sure to delete this item?'),
                'data-method' => 'post',
            ]); ?>
            <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-hover'],
                'attributes' => [
                    'name',
                    'description:ntext',
                    'ruleName',
                    'data:ntext',
                ],
            ]); ?>
        </div>
    </div>
    <?= $this->render('../_dualListBox', [
        'opts' => Json::htmlEncode([
            'items' => $model->getItems(),
        ]),
        'assignUrl' => ['assign', 'id' => $model->name],
        'removeUrl' => ['remove', 'id' => $model->name],
    ]); ?>
</div>
