<?php

use yii\grid\GridView;
/* @var $dataProvider yii\data\ActiveDataProvider */

?>

<div class="product-index table-scroll" id="lightgallery" style="padding: 20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover '
        ],
    ]) ?>

</div>
</div>