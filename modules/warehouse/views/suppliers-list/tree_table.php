<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreePartner)) : ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder"> <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                <?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'create')): ?>
                <i class="fa fa-plus" onclick="addPopup(<?= $tableTreePartner['id'] ?>)"></i>
                <?php endif; ?>
                <?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'update')): ?>
                <i style="margin-left:5px;" class="fa fa-pencil" onclick="editPopup(<?= $tableTreePartner['id'] ?>,$(this), 'suppliers-list/get-supplier')"></i>
                <?php endif; ?>
                <?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'delete')): ?>
                <i style="margin-left:5px;" class="fa fa-trash" onclick="deleteSup(<?= $tableTreePartner['id'] ?>,$(this))"></i>
                <?php endif; ?>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>

<?php endif; ?>
