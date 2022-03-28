<?php

use dmstr\helpers\Html;

$this->title = array(Yii::t('app', 'Create user'),'Create user');
$this->params['breadcrumbs'][] = $this->title[0];
?>

<div class="user-create">

    <h1 style="padding: 20px;" class="show-modal" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <?php echo $this->render('_form', [
            'model' => $user,
        'type' => 'create'
    ]); ?>
</div>