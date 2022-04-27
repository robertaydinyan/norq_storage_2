<?php

use dmstr\helpers\Html;
use yii\grid\GridView;
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isFavorite boolean */


$this->title = array(Yii::t('app', 'More about product'), 'More about product');
$this->params['breadcrumbs'][] = $this->title[0];
$hostname = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER[HTTP_HOST];
$table_all_columns = array(
    'id' => 'id',
    'WarehouseName' => [
        'label' => Yii::t('app', 'Warehouse name'),
        'format' => 'raw',
        'value' => function($product) {

            return
                Html::a( $product->warehouse->name,
                    ['#'],
                    ['onclick' => "showPage('/warehouse/warehouse/view?id=" . $product->warehouse->{'id'} . "','".$product->warehouse->name."')"]
                );

        }
    ],
    'ProductName' => [
        'label' => Yii::t('app', 'Product name'),
        'format' => 'raw',
        'value' => function($product) {
            return
                Html::a( $product->nomenclatureProduct->name,
                    ['#'],
                    ['onclick'=>"showPage('/warehouse/nomenclature-product/view?id=".$product->nomenclatureProduct->{'id'}."','".$product->nomenclatureProduct->name."')"]
                );

        }
    ],
    'price' => 'price',
    'currency' => [
        'label' => Yii::t('app', 'Currency'),
        'value' => function($model) {
            return $model->currencyData->symbol;
        }
    ],
    'comment' => 'comment',
    'created_at' => 'created_at',
    'invoice' => 'invoice',
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
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);


?>

<div class="product-index table-scroll" id="lightgallery" style="padding: 20px;">
    <div class="d-flex flex-wrap justify-content-between ">
        <h1  data-title=" <?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <div class="d-flex align-items-start pt-2">

            <button onclick="tableToExcel('tbl','test','products.xls')" class="btn btn-primary float-right mr-2">Xls</button>
            <button class="btn btn-primary mr-2 position-relative" style="float: right">
                <div id="list1" class="dropdown-check-list" tabindex="100" >
                    <span class="anchor"><i class="fa fa-list" ></i></span>
                    <ul class="items">
                        <?php if ($columns):
                            foreach ($columns as $i => $k): ?>
                                <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>"  checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                            <?php endforeach;
                        endif;?>
                    </ul>
                </div>
            </button>
            <button class="btn btn-primary mr-2 filter" style="float: right" data-type="2" data-model="Product"><i class="fa fa-wrench "></i></button>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => $table_columns,
    ]) ?>

</div>
