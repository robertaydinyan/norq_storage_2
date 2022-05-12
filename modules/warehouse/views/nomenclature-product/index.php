<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\NomenclatureProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $actions \app\modules\warehouse\models\Action[] */

$this->title = array(Yii::t('app', 'Product Nomenclature'),'Product Nomenclature');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

$actions = [
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
];

$table_all_columns = [
    'id' => [
        'label' =>  Yii::t('app', 'ID'),
        'format' => 'html',
        'value' => function ($model) {
            $isDeleted = $model->isDeleted;
            if ($isDeleted == 1){
                return $model->id . "<i class=\"fa fa-remove pl-3 text-danger\"></i>";

            }else {
                return  $model->id ;
            }
        }
    ],
    'vendor_code' => [
        'format'=>'raw',
        'label' => Yii::t('app', 'Vendor code'),
        'value' => function ($model) {
            return '<a href="#" onclick="showInfo('.$model->id.')">'.$model->vendor_code.'</a>';
        }
    ],
    'name' => 'name',
    'group' => [
        'attribute' => 'group_id',
        'label' => Yii::t('app', 'Group'),
        'value' => function ($model) {
            return $model->getGroupProduct()->one()['name'];
        }
    ],
    'production_date' => [
        'attribute' => 'production_date',
        'label' => Yii::t('app', 'Production date'),
        'value' => function($model) {
            return $model->production_date ?  date('d-m-Y', strtotime($model->production_date)) : null;
        }
    ],
    'expiration_date' => [
        'attribute' => 'expiration_date',
        'label' => Yii::t('app', 'Expiration date'),
        'value' => function($model) {
            return $model->expiration_date ?  date('d-m-Y', strtotime($model->expiration_date)) : null;
        }
    ],
//    'daysCount' => [
//        'label' => Yii::t('app', 'Days count'),
//        'value' => function($model) {
//            return ($model->production_date && $model->expiration_date) ?  (strtotime($model->expiration_date) - strtotime($model->production_date)) / (60 * 60 * 24) : null;
//        }
//    ],
    'series' => 'series',
    'ref' => 'ref',
    'expenditure_article_name' => [
        'attribute' => 'expenditure_article',
        'label' => Yii::t('app', 'Expenditure Article'),
        'value' => function($model) {
            return $model->expArticle->name;
        }
    ],
    'qty_type' => [
        'attribute' => 'qty_type',
        'label' => Yii::t('app', 'Quantity type'),
        'value' => function ($model) {
            return $model->getQtyType()->one()['type'];
        }
    ],
    'vat' => [
        'attribute' => 'is_vat',
        'label' => Yii::t('app', 'Vat'),
        'value' => function ($model) {
            return $model->vatName->name;
        }
    ],
    'manufacturer_name' => [
        'attribute' => 'manufacturer',
        'label' => Yii::t('app', 'Manufacturer'),
        'value' => function($model) {
            return $model->manufacturerName->name;
        }
    ],
    'technical_description' => 'technical_description',
    'comment' => 'comment',
    'other' => 'other',
    'individual' => [
        'attribute' => 'individual',
        'label' => Yii::t('app', 'Individual'),
        'value' => function ($model) {
            return Yii::t('app', $model->individual ? 'Yes' : 'No');
        }
    ],
    'count' => [
        'attribute' => 'count',
        'label' => Yii::t('app', 'Առկա է'),
        'value' => function ($model) {
            return $model->findCountByNom($model->id);
        }
    ],
    'barcode' => [
        'format' => 'html',
        'label' => Yii::t('app', 'Barcodes'),
        'value' => function ($model) {
            return $model->barcodes;
        }

    ]
];


$table_columns = [];
if (isset($columns)) {
    foreach ($columns as $column) {
        if ($table_all_columns[$column->row_name]) {
            array_push($table_columns, $table_all_columns[$column->row_name]);
        }
    }
}
if (count($table_columns) == 0){
    $table_columns = $table_all_columns;
}

array_push($table_columns, $actions);


?>
<?php if(\app\rbac\WarehouseRule::can('nomenclature-product', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('nomenclature-product', 'create')): ?>
                <a style="margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn  btn-primary" ><?php echo Yii::t('app', 'Create product nomenclature'); ?></a>
            <?php endif; ?>
            <button onclick="tableToExcel('tbl','test','nomenclature.xls')" class="btn btn-primary mr-2">Xls</button>

            <button class="btn btn-primary mr-2 position-relative" >
                <div id="list1" class="dropdown-check-list" tabindex="100" >
                    <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                    <ul class="items">
                        <?php if ($columns):
                            foreach ($columns as $i => $k):
                                if ($i == "barcode") continue; ?>
                                <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>" checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                            <?php endforeach;
                        endif;?>
                    </ul>
                </div>
            </button>
            <button class="btn btn-primary mr-2 filter"  data-model="NomenclatureProduct"><i class="fa fa-wrench "></i></button>
        </div>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="padding:20px;" >
        <div class="">
            <div class="row">
                <ul class="file-tree col-2" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
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
                <div class="col-sm-10" id="lightgallery">
                        <br>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => [
                                'class' => 'table table-hover'
                            ],
                            'columns' => $table_columns,
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