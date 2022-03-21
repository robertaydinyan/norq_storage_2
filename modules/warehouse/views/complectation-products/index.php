<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Complectation Products'), 'Complectation Products');
$this->params['breadcrumbs'][] = $this->title[0];
?>
<?php if(\app\rbac\WarehouseRule::can('complectation-products', 'index')): ?>
<div class="complectation-products-index">

    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?php if(\app\rbac\WarehouseRule::can('complectation-products', 'create')): ?>
        <p>
            <?= Html::a('Create Complectation Products', ['create'], ['class' => 'btn btn-primary']) ?>
        </p>
    <?php endif; ?>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'n_product_count',
            'complectation_id',
            'product_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
 <?php endif; ?>