<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ComplectationProducts */

$this->title = array('Complectation Products '.$model->id,'Complectation Products');
$this->params['breadcrumbs'][] = ['label' => 'Complectation Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
?>
<div class="complectation-products-view">

    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'n_product_count',
            'complectation_id',
            'product_id',
        ],
    ]) ?>

</div>
