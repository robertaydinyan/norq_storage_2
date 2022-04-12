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
            <?php if(!array_key_exists('children', $tableTreePartner)){
                $s = explode(' ', ShippingRequest::getPartnerTotalAmount($tableTreePartner['id']));
                ?>
               <?php echo ' <small style="margin-left:20px;">' . Yii::t('app', 'Debt') . '`'.number_format($s[0],0,'.',',') . ' ֏  <span style="cursor:pointer;" onclick="showInvoices('.$tableTreePartner['id'].')" data-toggle="modal" data-target="#viewInfo">(' . Yii::t("app", "invoices") . ')</span><samll>'; ?>
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
