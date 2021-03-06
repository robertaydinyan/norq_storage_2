<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchSuppliersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'co-workers'),'co-workers');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }

</style>
<?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?> <span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;">
        <div>
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                    <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                             <?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'create')): ?>
                            <i class="fa fa-plus" onclick="addPopup(<?= $tableTreePartner['id'] ?>)"></i>
                             <?php endif; ?>
                             <?php if(\app\rbac\WarehouseRule::can('suppliers-list', 'update')): ?>
                            <i style="margin-left:5px;" class="fa fa-pencil" onclick="editPopup(<?= $tableTreePartner['id'] ?>,$(this), 'suppliers-list/get-supplier')"></i>
                             <?php endif; ?>
                        </span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_table.php', [
                                'tableTreePartner' => $tableTreePartner,
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="addGroup" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form method="post" action="">
                    <input type="hidden" name="_csrf" value="UvFGCxza780T3mp_WyLZazh2DQwueuKMsksAY0R7RqMdky1ic769q3mbKz0qa7ASb0UgfEo_jrjoH3U6HE8qzg==">

                    <label for="fname"><?php echo Yii::t('app', 'Name'); ?></label><br>
                    <input type="text" class="form-control" id="fname" name="name"><br>

<!--                    <label for="fname2">--><?php //echo Yii::t('app', 'Name(Russian)'); ?><!--</label><br>-->
<!--                    <input type="text" class="form-control" id="fname2" name="name_ru"><br>-->
<!---->
<!--                    <label for="fname3">--><?php //echo Yii::t('app', 'Name(English)'); ?><!--</label><br>-->
<!--                    <input type="text" class="form-control" id="fname3" name="name_en"><br>-->

                    <label for="vat"><?php echo Yii::t('app', 'Vat'); ?></label><br>
                    <input type="text" class="form-control" id="vat" name="vat"><br>

                    <label for="legal_address"><?php echo Yii::t('app', 'Legal Address'); ?></label><br>
                    <input type="text" class="form-control" id="legal_address" name="legal_address"><br>

                    <label for="business_address"><?php echo Yii::t('app', 'Business Address'); ?></label><br>
                    <input type="text" class="form-control" id="business_address" name="business_address"><br>

                    <label for="phone"><?php echo Yii::t('app', 'Phone'); ?></label><br>
                    <input type="text" class="form-control" id="phone" name="phone"><br>

                    <label for="email"><?php echo Yii::t('app', 'Email'); ?></label><br>
                    <input type="text" class="form-control" id="email" name="email"><br>

                    <label for="comment"><?php echo Yii::t('app', 'Comment'); ?></label><br>
                    <input type="text" class="form-control" id="comment" name="comment"><br>

                    <label for="contract_type"><?php echo Yii::t('app', 'Contract Type'); ?></label><br>
                    <select class="" id="contract_type" name="contract_type">
                        <option selected disabled value=""></option>
                        <option value="1">????????????????</option>
                        <option value="2">????????????????</option>
                    </select><br>

                    <input type="hidden" id="group_id" name="parent_id">
                    <button class="btn btn-primary"><?php echo Yii::t('app', 'Save'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editeGroup" tabindex="-1" role="dialog" aria-labelledby="editeGroup" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <form method="post" action="">
                    <input type="hidden" name="_csrf" value="UvFGCxza780T3mp_WyLZazh2DQwueuKMsksAY0R7RqMdky1ic769q3mbKz0qa7ASb0UgfEo_jrjoH3U6HE8qzg==">

                    <label for="fname__"><?php echo Yii::t('app', 'Name'); ?></label><br>
                    <input type="text" class="form-control" id="fname__" name="name"><br>

                    <label for="vat_"><?php echo Yii::t('app', 'Vat'); ?></label><br>
                    <input type="text" class="form-control" id="vat_" name="vat"><br>

                    <label for="legal_address_"><?php echo Yii::t('app', 'Legal Address'); ?></label><br>
                    <input type="text" class="form-control" id="legal_address_" name="legal_address"><br>

                    <label for="business_address_"><?php echo Yii::t('app', 'Business Address'); ?></label><br>
                    <input type="text" class="form-control" id="business_address_" name="business_address"><br>

                    <label for="phone_"><?php echo Yii::t('app', 'Phone'); ?></label><br>
                    <input type="text" class="form-control" id="phone_" name="phone"><br>

                    <label for="email_"><?php echo Yii::t('app', 'Email'); ?></label><br>
                    <input type="text" class="form-control" id="email_" name="email"><br>

                    <label for="comment_"><?php echo Yii::t('app', 'Comment'); ?></label><br>
                    <input type="text" class="form-control" id="comment_" name="comment"><br>

                    <label for="contract_type_"><?php echo Yii::t('app', 'Contract Type'); ?></label><br>
                    <select class="" id="contract_type_" name="contract_type">
                        <option selected disabled value=""></option>
                        <option value="1">????????????????</option>
                        <option value="2">????????????????</option>
                    </select><br>

                    <input type="hidden" id="id" name="id">
                    <button class="btn btn-primary" type="submit" name="update_button"><?php echo Yii::t('app', 'Save'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>