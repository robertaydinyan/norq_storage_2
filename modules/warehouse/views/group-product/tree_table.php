<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProdgucts yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder" data-id="<?= $tableTreeGroup['id'] ?>"> <span data-name="<?= $tableTreeGroup['name_' . $lang] ?>" class="parent-block"><?= $tableTreeGroup['name_' . $lang] ?>
                <i class="fa fa-plus" onclick="addPopup(<?= $tableTreeGroup['id'] ?>)"></i>
                <i style="margin-left:5px;" class="fa fa-pencil" onclick="editPopup(<?= $tableTreeGroup['id'] ?>,$(this), 'group-product/get-group')"></i>
                <i style="margin-left:5px;" class="fa fa-trash" onclick="deletePopup(<?= $tableTreeGroup['id'] ?>,$(this))"></i>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/group-product/tree_table.php', [
                        'tableTreeGroup' => $tableTreeGroup,
                        'groupProducts' => $groupProducts
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php else : ?>
        <ul style="display: block;">
            <?php $groupProductsTabele = $groupProducts->where(['s_group_product.id'=> $tableTreeGroup['id']])->asArray()->all() ?>
            <?php if (!empty($groupProductsTabele)) : ?>
                <a href="<?= \app\components\Url::to(['/warehouse/group-product/show-group-products', 'group_id' => $tableTreeGroup['id'], 'lang' => Yii::$app->language]) ?>">
                    <i class="fal fa-file-export"><?php echo Yii::t('app', 'goods'); ?> (<?php echo $groupProducts->where(['s_group_product.id'=> $tableTreeGroup['id'],'s_product.status'=> 1])->count() ?>)</i>
                </a>
            <?php else: ?>
                <p><?php Yii::t('app', 'There are no products'); ?></p>
            <?php endif; ?>
        </ul>
<?php endif; ?>