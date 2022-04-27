<?php

use app\modules\warehouse\models\NomenclatureProduct;
use yii\helpers\Url;
/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder"> <span data-name="l<?= $tableTreeGroup['name_' . $lang] ?>"> <?= $tableTreeGroup['name_' . $lang] ?></span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_second.php', [
                    'tableTreeGroup' => $tableTreeGroup,
                ]); ?>
            </ul>
            <br>
        </li>
    <?php endforeach; ?>
<?php else : ?>
    <ul style="display: block;padding-left: 0px;" >
        <li><a href="<?= Url::to(['index', 'id' => $tableTreeGroup['id']]) ?>"><?php echo Yii::t('app', 'goods'); ?> ( <?=NomenclatureProduct::findCountByGroup($tableTreeGroup['id'])?> <?php echo Yii::t('app', 'Nom.') ?>)</a></li>
    </ul>
<?php endif; ?>