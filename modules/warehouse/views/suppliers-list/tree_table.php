<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<?php if(array_key_exists('children', $tableTreePartner)) : ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder"> <span data-name="<?= $tableTreePartner['name_' . $lang] ?>" class="parent-block"><?= $tableTreePartner['name_' . $lang] ?>
                <i class="fa fa-plus" onclick="addPopup(<?= $tableTreePartner['id'] ?>)"></i>
                <i style="margin-left:5px;" class="fa fa-pencil" onclick="editPopup(<?= $tableTreePartner['id'] ?>,$(this), 'suppliers-list/get-supplier')"></i>
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
