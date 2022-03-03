<?php

use Yii;
use app\modules\warehouse\models\ShippingRequest;
/* @var $tableTreeGroup yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */
?>
<?php if(array_key_exists('children', $tableTreePartner)){ ?>
    <?php foreach ($tableTreePartner['children'] as $tableTreePartner) : ?>
        <li class="file-tree-folder" style="display: block;"> <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
            <?php if(!array_key_exists('children', $tableTreePartner)){ ?>
               <?php echo ' <small style="margin-left:20px;">' . Yii::t('app', 'Debt') . '`'.number_format(ShippingRequest::getPartnerTotalAmount($tableTreePartner['id']),0,'.',',') . ' ' .  Yii::t('app', 'dram') .'  <span style="cursor:pointer;" onclick="showInvoices('.$tableTreePartner['id'].')" data-toggle="modal" data-target="#viewInfo">(invoices)</span><samll>'; ?>
            <?php } ?>
            </span>
            <ul style="display: block;">
                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/payments/tree_table.php', [
                    'tableTreePartner' => $tableTreePartner,
                ]); ?>
            </ul>
        </li>
    <?php endforeach; ?>
<?php } ?>
