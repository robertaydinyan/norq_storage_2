<?php

use app\modules\warehouse\models\NomenclatureProduct;
use yii\helpers\Url;
/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php $id = $tableTreeGroup['id'];?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        {id: <?= $tableTreeGroup['id'] ?>, pId: <?=$id?>, name: "<?= $tableTreeGroup['name'] ?>", open: false,click:'setGroup(<?=$tableTreeGroup['id'];?>,$(this))'},
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/product/tree_table.php', [
                    'tableTreeGroup' => $tableTreeGroup,
                ]); ?>
    <?php endforeach; ?>
<?php else : ?>
    <?php
       $products = NomenclatureProduct::find()->where(['group_id'=>$id])->all();
       foreach ($products as $product =>$prod_val){ ?>
           {id: 1000<?= $prod_val->id ?>, pId: <?=$id?>, name: "<?=$prod_val->name ?>",click:'getProducts(<?= $prod_val->id ?>)'},
    <?php }
    ?>

<?php endif; ?>


