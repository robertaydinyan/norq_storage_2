<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\ActiveQuery;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\GroupProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tableTreeGroups yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */

$this->title =  array(Yii::t('app', 'Product group'),'Product group');
$this->params['breadcrumbs'][] = $this->title[0];

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }

    .ui-sortable-handle {
        -webkit-transition: none !important;
    }

</style>
<div class="group-product-index" >
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <p><button class="btn  btn-primary"  onclick="addPopup(0)"><?php echo Yii::t('app', 'Create a Product Group'); ?></button></p>
    </div>
    <div style="display: flex">
        <div class="col-lg-12">
            <ul class="file-tree sortable" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;" id="sortable-category">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder" data-id="<?= $tableTreeGroup['id'] ?>"> <span data-name="<?= $tableTreeGroup['name'] ?>" class="parent-block"> <?= $tableTreeGroup['name'] ?>
                            <i class="fa fa-plus" onclick="addPopup(<?= $tableTreeGroup['id'] ?>)"></i>
                            <i style="margin-left:5px;" class="fa fa-pencil" onclick="editPopup(<?= $tableTreeGroup['id'] ?>,$(this), 'group-product/get-group')"></i>
                            <i style="margin-left:5px;" class="fas <?= (!$tableTreeGroup['isDeleted'] ? 'fa-trash-alt' : 'fa-undo') ?> " onclick="deletePopup(<?= $tableTreeGroup['id'] ?>,$(this))"></i>
                        </span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/group-product/tree_table.php', [
                                'tableTreeGroup' => $tableTreeGroup,
                                'groupProducts' => $groupProducts
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
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
                          <input type="hidden" id="group_id" name="group_id">
                          <button class="btn btn-primary"><?php echo Yii::t('app', 'Add'); ?></button>
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
                        <input type="hidden" id="id" name="id">
                        <button class="btn btn-primary" type="submit" name="update_button"><?php echo Yii::t('app', 'Save'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>

<!---->
<!--<script>-->
<!--    window.addEventListener('load', function () {-->
<!---->
<!--        $( ".sortable" ).sortable({-->
<!--            connectWith: ".parent-block"-->
<!--        }).disableSelection();-->
<!--    });-->
<!--</script>-->
<script>
    window.addEventListener('load', function () {
        $('#sortable-category').sortable({
            items: 'li',
            toleranceElement: '> span',
            update: function(event, el) {
                let item = $(el.item[0]);
                let itemID = item.data('id');
                let parentID = item.parent().parent().data('id');
                let order = item.index();

                $.post('/warehouse/group-product/change-order', {
                    order: order + 1,
                    parentID: parentID,
                    itemID: itemID
                }).done(function(res) {
                    console.log(res)
                })
            }
        });
    });
</script>