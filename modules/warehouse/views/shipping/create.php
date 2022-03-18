<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Shipping */

$this->title = 'Create Shipping';
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shipping-create">

    <h1><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
