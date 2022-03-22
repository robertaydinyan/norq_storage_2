<?php

/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<?php if(array_key_exists('children', $tableTreePartner)) : ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder"> <span data-name="<?= $tableTreePartner['name_' . $lang] ?>" class="parent-block"><?= $tableTreePartner['name_' . $lang] ?>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_form_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                    'checked' => $checked,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>

<?php else : ?>
    <ul style="display: block;padding-left:0px;">
        <div class="form-row">
             <?php if(intval($tableTreePartner['id']) != 20){ ?>
                
                    <input type="radio"
                           value= <?=$tableTreePartner['id']; ?>
                           id="<?php echo $tableTreePartner['id']; ?>"
                           class="form-control"
                          <?php if($checked == $tableTreePartner['id']){ echo 'checked';}?>
                           name="ShippingRequest[supplier_id]" >
                    <label class="has-star" for="<?php echo $tableTreePartner['id']; ?>"><?= Yii::t('app', 'Ընտրել') ?></label>
                    <div class="help-block invalid-feedback"></div>
           
              <?php } else { ?>
                <div class="search">
                    <div class="row">
                        <div class="col-sm-10">
                              <input type="text" id="search_input" class="form-control">
                        </div>
                        <div class="col-sm-2">
                             <button type="button" id="search_button" class="btn btn-primary"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="col-sm-12" id="search_results">
                            
                        </div>
                    </div>
                  
                   
                </div>
              <?php } ?>

        </div>
    </ul>

<?php endif; ?>

