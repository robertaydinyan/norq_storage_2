<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreeGroup)) : ?>
    <?php foreach ($tableTreeGroup['children'] as $tableTreeGroup) : ?>
        <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name'] ?></span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_mm.php', [
                    'tableTreeGroup' => $tableTreeGroup,
                    'id' => $id
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php else : ?>
    <ul style="display: block;">
        <div class="form-row">
                <input type="radio" style="margin:5px;"
                       value= <?=$tableTreeGroup['id']; ?>
                       id="item<?php echo $tableTreeGroup['id']; ?>"
                       class="ctr"
                       <?php echo $id == $tableTreeGroup['id'] ? 'checked' : ''; ?>
                       name="Product[group_id]"
                >
                <label class="has-star" for="item<?php echo $tableTreeGroup['id']; ?>"><?= Yii::t('app', 'Select') ?></label>
                <div class="help-block invalid-feedback"></div>
            

        </div>
    </ul>
<?php endif; ?>
