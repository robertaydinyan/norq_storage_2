<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Currency */

$this->title = array(Yii::t('app', 'Currency') . ': ' . $model->symbol, 'Currency: ' . $model->symbol);
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="currency-view">

    <h1 data-title="Html::encode($this->title[1]"><?= Html::encode($this->title[0]) ?></h1>

    <p>
        <?php
            if (\app\rbac\WarehouseRule::can('currency', 'update')) {
                echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
            }
        ?>
        <?php if (\app\rbac\WarehouseRule::can('currency', 'delete')) {
            echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]);
        } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'symbol',
        ],
    ]) ?>

</div>
