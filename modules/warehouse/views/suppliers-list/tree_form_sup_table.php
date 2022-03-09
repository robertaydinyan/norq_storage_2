<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<input type="hidden" name="lang" value="<?php echo Yii::$app->language; ?>">
<?php if(array_key_exists('children', $tableTreePartner)) : ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder"> <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_form_sup_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                    'checked' => $checked,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>

<?php else : ?>
    <ul style="display: block;padding-left:0px;">
        <div class="form-row">
                <input type="radio"
                       value= <?=$tableTreePartner['id']; ?>
                       id="<?php echo $tableTreePartner['id']; ?>"
                       class="form-control ck"
                      <?php if($checked == $tableTreePartner['id']){ echo 'checked';}?>
                       name="ShippingRequest[supplier_id]" >
                <label class="has-star" for="<?php echo $tableTreePartner['id']; ?>"><?= Yii::t('app', 'Ընտրել') ?></label>
                <div class="help-block invalid-feedback"></div>
        </div>
    </ul>
 
<?php endif; ?>


