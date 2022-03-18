<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\PartnersList */

$this->title = 'Create Partners List';
$this->params['breadcrumbs'][] = ['label' => 'Partners Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partners-list-create">

    <h1><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
