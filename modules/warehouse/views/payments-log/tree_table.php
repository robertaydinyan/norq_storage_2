<?php

use Yii;
use app\modules\warehouse\models\ShippingRequest;
/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<?php if(array_key_exists('children', $tableTreePartner)){ ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder" style="display: block;"> <span data-name="<?= $tableTreePartner['name_' . $lang] ?>" class="parent-block"><?= $tableTreePartner['name_' . $lang] ?>
            <?php if(!array_key_exists('children', $tableTreePartner)){ ?>
               <?php echo '<input type="radio" style="position:relative;left:0px;" value="'.$tableTreePartner['id'].'" name="ProviderPayments[provider_id]">'; ?>
            <?php } ?>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/payments-log/tree_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php } ?>
