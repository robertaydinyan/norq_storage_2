<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder" data-id="<?= $tableTreeGroup['id'] ?>"> <span data-name="<?= $tableTreeGroup['name'] ?>" class="parent-block"><?= $tableTreeGroup['name'] ?>
                <i class="fa fa-plus" onclick="addPopup(<?= $tableTreeGroup['id'] ?>)"></i>
                <i style="margin-left:5px;" class="fa fa-pencil" onclick="editePopup(<?= $tableTreeGroup['id'] ?>,$(this))"></i>
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
                <a href="<?= \app\components\Url::to(['/warehouse/group-product/show-group-products', 'group_id' => $tableTreeGroup['id']]) ?>">
                    <i class="fal fa-file-export">Ապրանքներ (<?php echo $groupProducts->where(['s_group_product.id'=> $tableTreeGroup['id'],'s_product.status'=> 1])->count() ?>)</i>
                </a>
            <?php else: ?>
                <p>Ապրանքներ չկան</p>
            <?php endif; ?>
        </ul>
<?php endif; ?>