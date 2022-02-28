<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreePartner)) : ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder"> <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                <i class="fa fa-plus" onclick="addPopup(<?= $tableTreePartner['id'] ?>)"></i>
                <i style="margin-left:5px;" class="fa fa-pencil" onclick="editePopup(<?= $tableTreePartner['id'] ?>,$(this))"></i>
                <i style="margin-left:5px;" class="fa fa-trash" onclick="deleteSup(<?= $tableTreePartner['id'] ?>,$(this))"></i>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>

<?php endif; ?>
