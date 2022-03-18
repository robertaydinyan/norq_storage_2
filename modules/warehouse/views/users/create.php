<?php

use dmstr\helpers\Html;

$this->title = Yii::t('app', 'Create user');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-create">

    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?php echo $this->render('_form', [
            'model' => $user
    ]); ?>
</div>