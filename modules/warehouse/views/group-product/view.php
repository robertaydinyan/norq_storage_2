<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\GroupProduct */
$this->title = array($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Group Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="group-product-view group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <div style="padding:20px;">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-hover'],
            'attributes' => [
                'id',
                'name',
                [
                    'attribute' => 'group_id',
                    'label' => 'Group name',
                    'value' => function ($model) {
                        return $model->parentGroup->name;
                    }
                ],
            ],
        ]) ?>
    </div>
    <p style="padding:20px;">
        <?= Html::a('Փոփոխել', ['update', 'id' => $model->id], ['class' => 'btn  btn-primary']) ?>
        <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
