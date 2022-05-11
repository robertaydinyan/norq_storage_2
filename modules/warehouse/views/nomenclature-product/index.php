<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\NomenclatureProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Product Nomenclature'),'Product Nomenclature');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<?php if(\app\rbac\WarehouseRule::can('nomenclature-product', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div>
    <?php if(\app\rbac\WarehouseRule::can('nomenclature-product', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn  btn-primary" ><?php echo Yii::t('app', 'Create product nomenclature'); ?></a>
    <?php endif; ?>
    </div>
</div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="padding:20px;" >
        <div class="">
            <div class="row">
                <ul class="file-tree col-3" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                    <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                        <li class="file-tree-folder"> <span data-name="l<?= $tableTreeGroup['name'] ?>"> <?= $tableTreeGroup['name'] ?> </span>
                            <ul style="display: block;">
                                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_second.php', [
                                    'tableTreeGroup' => $tableTreeGroup,
                                ]); ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>

                </ul>
                <div class="col-sm-9" id="lightgallery">
                        <br>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'table table-hover'
                            ],
                            'columns' => [
//
                                [
                                    'format'=>'raw',
                                    'label' => Yii::t('app', 'Vendor code'),
                                    'value' => function ($model) {
                                        return '<a href="#" onclick="showInfo('.$model->id.')">'.$model->vendor_code.'</a>';
                                    }
                                ],
                                //'groupProduct.name',
                                [
                                    'attribute' => 'groupName',
                                    'label' => Yii::t('app', 'Group'),
                                    'value' => function ($model) {
                                        return $model->groupProduct->name;
                                    }
                                ],
                                [
                                    'attribute' => 'count',
                                    'label' => Yii::t('app', 'Առկա է'),
                                    'value' => function ($model) {
                                        return $model->findCountByNom($model->id);
                                    }
                                ],
                                [
                                    'attribute' => 'qty_typ',
                                    'label' => Yii::t('app', 'Չմ'),
                                    'value' => function ($model) {
                                        return $model->qtyType->type;
                                    }
                                ],
                                //'type',
                                //'individual',
                                //'qty_type',
                                //'group_id',

                                [
                                    'class' => 'yii\grid\ActionColumn',
                                    'header' => Yii::t('app', 'Action'),
                                    'template' => '{view}{update}{delete}',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return \app\rbac\WarehouseRule::can('nomenclature-product', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url, [
                                                'title' => Yii::t('app', 'View'),
                                                'class' => 'btn text-primary btn-sm mr-2'
                                            ]) : '';
                                        },

                                        'update' => function ($url, $model) {
                                            return
                                                \app\rbac\WarehouseRule::can('nomenclature-product', 'update') ?   Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                                    'title' => Yii::t('app', 'Update'),
                                                    'class' => 'btn text-primary btn-sm mr-2'
                                                ]) : '';
                                        },
                                        'delete' => function ($url, $model) {
                                            return \app\rbac\WarehouseRule::can('nomenclature-product', 'delete') ? 
                                            Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [                     
                                                'title' => Yii::t('app', 'Delete'),
                                                'class' => 'btn text-danger btn-sm',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                                    'method' => 'post',
                                                ],
                                            ]) : '';
                                        }

                                    ]
                                ],
                            ],
                        ]); ?>
                     <div id="product_info"></div>
                </div>

            </div>
         
        </div>

    </div>
    
</div>
<style>
    .summary{
        margin-bottom:20px;
    }
</style>
<?php endif; ?>
<script>
    function showInfo(nom_id){
        $.ajax({
            type: "GET",
            url: "/warehouse/product/show-data",
            data: {
                id: nom_id
            },
            cache: false,
            dataType: 'html',
            success: function(res) {
                $('#product_info').html(res);
            }
        });
    }
</script>