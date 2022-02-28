<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ապրանքի Նոմենկլատուրա', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="nomenclature-product-view group-product-index">

    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?></h4>


    <div style="padding:20px;">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'vendor_code',
            'name',
            'group',
            'production_date',
            'type',
            'individual',
            'qty_type',
            'group_id',
        ],
    ]) ?>
    </div>
    <p style="padding:20px;">
        <?= Html::a('Փոփոխել', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
