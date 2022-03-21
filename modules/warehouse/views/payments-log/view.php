<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */

$this->title = array($model->id);
$this->params['breadcrumbs'][] = ['label' => 'Qty Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="qty-type-view group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;">Վճարում ։ <?= Html::encode($model->id) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>



    <div class="col-lg-4">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-hover'],
            'attributes' => [
                'id',
                'price',
                'invoice',
            ],
        ]) ?>
    </div>
    <p style="padding: 20px;">
        <?= Html::a('Ջնջել', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-sm btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
