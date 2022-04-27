<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
use app\modules\warehouse\models\Warehouse;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ProductSearch */
/* @var $model app\modules\warehouse\models\ProductSearch */
/* @var $physicalWarehouse app\modules\warehouse\models\ProductSearch */
/* @var $requestSearch app\modules\warehouse\models\ProductSearch */
/* @var $nProducts app\modules\warehouse\models\ProductSearch */
/* @var $users app\modules\warehouse\models\ProductSearch */
/* @var $address app\modules\warehouse\models\ProductSearch */
/* @var $regions app\modules\warehouse\models\ProductSearch */
/* @var $groups app\modules\warehouse\models\ProductSearch */
/* @var $rols app\modules\warehouse\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dataProvider2 yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'goods'),'goods');
$this->params['breadcrumbs'][] = $this->title[0];
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
$hostname = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER[HTTP_HOST];

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/createProduct.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

$table_all_columns = array(
    'id' => 'id',
    'WarehouseName' => [
        'label' => Yii::t('app', 'Warehouse name'),
        'format' => 'raw',
        'value' => function($product) use ($lang) {

            return
            Html::a( $product->warehouse->{'name_' . $lang},    
                '#', [
                    'onclick' => "showPage('/warehouse/warehouse/view?id=".$product->warehouse->{'id'}."','".$product->warehouse->{'name_' . $lang}."')"]
            );
             
        }
    ],
    'ProductName' => [
        'label' => Yii::t('app', 'Product name'),
        'format' => 'raw',
        'value' => function($product) use ($lang) {
            return           

            Html::a( $product->nomenclatureProduct->{'name_' . $lang},    
                                '#',
                                ['onclick'=>"showPage('/warehouse/nomenclature-product/view?id=".$product->nomenclatureProduct->{'id'}."','".$product->nomenclatureProduct->{'name_' . $lang}."')"]
                    );

        }
    ],
//    'ProductPicture' => [
//        'label' => Yii::t('app', 'Product Picture'),
//        'format' => 'html',
//        'contentOptions' => function($model) use ($lang, $hostname) {
//            return [
//                'data-responsive' => "https://sachinchoolur.github.io/lightgallery.js/static/img/13-375.jpg 375, https://sachinchoolur.github.io/lightgallery.js/static/img/13-480.jpg 480, https://sachinchoolur.github.io/lightgallery.js/static/img/13.jpg 800",
//                'data-sub-html' => "<h4 style='color: white'>" . $model->nomenclatureProduct->{'name_' . $lang} . "</h4>",
//                'class' => 'image',
//                'data-src' => $hostname . $model->nomenclatureProduct->img
//            ];
//        },
//        'value' => function($product) use ($lang, $hostname) {
//            return sprintf('<img class="img-responsive"   width="100" src="%s">',
//
//                $hostname . $product->nomenclatureProduct->img,
//
//            );
//        },
//
//    ],
    'Quantity' => [
        'label' => Yii::t('app', 'Quantity'),
        'value' => function($product) use ($lang) {
            return  $product->count . ' ' . $product->nProduct->qtyType->{'type_' . $lang};
        }
    ],
    'Individual' => [
        'label' => Yii::t('app', 'Individual'),
        'value' => function($product) {
            return Yii::t('app', $product->nomenclatureProduct->individual=='true' ? 'Yes' : 'No');
        }
    ]
);

$table_columns = [];

if (isset($columns)) {
    foreach ($columns as $column) {
        if ($table_all_columns[$column->row_name]) {
            array_push($table_columns, $table_all_columns[$column->row_name]);
        }
    }
}
if (count($table_columns) == 0) {
    $table_columns = $table_all_columns;
}
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

<div class="group-product-index">
    <div class="d-flex flex-wrap justify-content-between ">
        <h1  data-title=" <?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <div class="d-flex align-items-start pt-2">
            <?php echo \app\rbac\WarehouseRule::can('group-product', 'show-group-products') ?
                '<a href="' . URL::to(['/warehouse/group-product/show-group-products']) . '" class="btn btn-primary mr-2" style="float: right;">' .
                    Yii::t('app', 'Product group') .
                '</a>'
            : ''; ?>

            <?php echo \app\rbac\WarehouseRule::can('group-product', 'show-group-products') ?
                '<a href="' . URL::to(['/warehouse/product/product-more']) . '" class="btn btn-primary mr-2" style="float: right;">' .
                    Yii::t('app', 'More about product') .
                '</a>'
            : ''; ?>

            <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary float-right mr-2">Xls</button>
            <button class="btn btn-primary mr-2 position-relative" style="float: right">
                <div id="list1" class="dropdown-check-list" tabindex="100" >
                    <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                    <ul class="items">
                        <?php if ($columns):
                            foreach ($columns as $i => $k): ?>
                                <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>"  checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                            <?php endforeach;
                        endif;?>
                    </ul>
                </div>
            </button>
            <button class="btn btn-primary mr-2 filter" style="float: right" data-type="1" data-model="Product"><i class="fa fa-wrench "></i></button>
        </div>
    </div>

    <div class="product-index table-scroll" id="lightgallery" style="padding: 20px;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider2,
            'tableOptions' => [
                'class' => 'table table-hover '
            ],
            'columns' => $table_columns,
        ]) ?>

    </div>
</div>

<div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="mod-content"></div>
                </div>
            </div>

        </div>
    </div>





<script>
    function showInfo(id,wid){
    if(id){
        $.ajax({
            url: '/warehouse/warehouse/get-product-info',
            method: 'get',
            dataType: 'html',
            data: { id: id,wid:wid},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}
</script>