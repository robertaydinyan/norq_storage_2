<?php

use app\modules\warehouse\models\NomenclatureProduct;
use yii\helpers\Url;
/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder"> <span data-name="l<?= $tableTreeGroup['name'] ?>"> <?= $tableTreeGroup['name'] ?></span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_second.php', [
                    'tableTreeGroup' => $tableTreeGroup,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php else : ?>
    <ul style="display: block;padding-left: 0px;" >
        <li><a href="<?= Url::to(['index']) ?>?id=<?=$tableTreeGroup['id']?> ">Ապրանքներ ( <?=NomenclatureProduct::findCountByGroup($tableTreeGroup['id'])?> Նոմ․)</a></li>
    </ul>
<?php endif; ?>