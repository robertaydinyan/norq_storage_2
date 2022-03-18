<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchSuppliersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'co-workers');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
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
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?> <span class="star" ><i class="fa fa-star-o ml-4"></i></span></h1>
    <div style="padding:20px;">
        <div>
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                    <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name_' . $lang] ?>" class="parent-block"><?= $tableTreePartner['name_' . $lang] ?>
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
                    <label for="fname"><?php echo Yii::t('app', 'Name(Armenian)'); ?></label><br>
                    <input type="text" class="form-control" id="fname" name="name_hy"><br>
                    <label for="fname2"><?php echo Yii::t('app', 'Name(Russian)'); ?></label><br>
                    <input type="text" class="form-control" id="fname2" name="name_ru"><br>
                    <label for="fname3"><?php echo Yii::t('app', 'Name(English)'); ?></label><br>
                    <input type="text" class="form-control" id="fname3" name="name_en"><br>
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
                    <label for="fname__"><?php echo Yii::t('app', 'Name(Armenian)'); ?></label><br>
                    <input type="text" class="form-control" id="fname__" name="name_hy"><br>
                    <label for="fname2__"><?php echo Yii::t('app', 'Name(Russian)'); ?></label><br>
                    <input type="text" class="form-control" id="fname2__" name="name_ru"><br>
                    <label for="fname3__"><?php echo Yii::t('app', 'Name(English)'); ?></label><br>
                    <input type="text" class="form-control" id="fname3__" name="name_en"><br>
                    <input type="hidden" id="id" name="id">
                    <button class="btn btn-primary" type="submit" name="update_button"><?php echo Yii::t('app', 'Save'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>
<br>


