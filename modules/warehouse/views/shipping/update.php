<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Shipping */

$this->title = array(Yii::t('app', 'Update Shipping') . ' : ' . $model->id, 'Update Shipping');
$this->params['breadcrumbs'][] = ['label' => 'Shippings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] =  $this->title[0];
?>
<div class="shipping-update">

    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
