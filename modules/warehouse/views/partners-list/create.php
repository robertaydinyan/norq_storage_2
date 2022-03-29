<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\PartnersList */

$this->title = array(Yii::t('app', 'Create Partners List'), 'Create Partners List');
$this->params['breadcrumbs'][] = ['label' => 'Partners Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="partners-list-create form-data">

    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'type' => 'create'
    ]) ?>

</div>
