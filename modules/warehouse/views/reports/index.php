<?php
use \app\modules\warehouse\models\Product;
use app\modules\warehouse\models\Warehouse;
use kartik\date\DatePicker;
use yii\helpers\Html;

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/shipping_new.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->title = array(Yii::t('app', 'Reports'),'Reports');
$this->params['breadcrumbs'][] =  $this->title[0];
?>

<style>
    .select2-results__options--nested{
        padding-left: 10px;
    }
</style>
  <script defer type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script defer type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script defer type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script defer type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <link  rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
<?php if(\app\rbac\WarehouseRule::can('reports', 'index')): ?>

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
<div class="shipping-request-create group-product-index">
    <br>
<form class="row" action="" id="report_form" method="get" style="padding: 20px;">
    <input type="hidden" name="lang" value="<?php echo Yii::$app->language; ?>">
    <div class="col-sm-12" style="margin-bottom: 10px;">
        <div class="row">
<!--            sharzh mnacord yst apranqneri-->
            <div class="form-group">
                <label for="report-type"><?php echo Yii::t('app', 'Type'); ?></label>
                <select class="form-control" id="report-type" onchange="reportStatusChanged(parseInt($(this).val()))">
                    <option value=""><?php echo Yii::t('app', 'Select'); ?></option>
                    <option value="1"><?php echo Yii::t('app', 'Product Movement'); ?></option>
                    <option value="2"><?php echo Yii::t('app', 'Product balance'); ?></option>
                    <option value="3"><?php echo Yii::t('app', 'By Products'); ?></option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="warehouse-type col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 mb-3" style="display: none">
                <select name="warehouse_type" class="form-control warehouse_type btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Warehouse type'); ?></option>
                    <?php if(!empty($warehouse_types)){
                        foreach ($warehouse_types as $warehouse =>$wh){
                            echo '<option  value="'.$warehouse.'" >'.$wh.'</option>';
                        }
                    } ?>
                </select>
            </div>

            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 hide subgroup">
                <select name="virtual_type" <?php if(@!$_GET['virtual_type']){ echo 'hide';}?> class="form-control virtual_type  btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Virtual (types)'); ?></option>
                    <?php if(!empty($groups)){
                        foreach ($groups as $group =>$gr){
                            echo '<option  value="'.$group.'" >'.$gr.'</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 <?php if(@!$_GET['community_id']){ echo 'hide';}?> community">
                <select name="community_id" class="form-control community_select btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Community'); ?></option>
                </select>
            </div>
            <div class="col-12 col-sm-4	col-md-3 col-lg-3	col-xl-2 hide ware" <?php if(@!$_GET['supplier_warehouse_id']){ echo 'hide';}?>>
                <select name="supplier_warehouse_id" class="form-control ware_select btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Warehouse'); ?></option>
                </select>
            </div>
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 start" style="display: none">
                 <?php 
                    echo DatePicker::widget([
                        'name' => 'from_created_at', 
                        'value' => $_GET['from_created_at'],
                        'options' => ['placeholder' => Yii::t('app', 'Start')],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true
                        ]
                    ]);
                    ?>
               
            </div>
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 end" style="display: none">
                <?php 
                    echo DatePicker::widget([
                        'name' => 'to_created_at', 
                        'value' => $_GET['to_created_at'],
                        'options' => ['placeholder' => Yii::t('app', 'End')],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true
                        ]
                    ]);
                    ?>
            </div>
            <div class="clearfix"></div>
            <hr>

        </div>
    </div>
    <?php if(\app\rbac\WarehouseRule::can('reports', 'generate')): ?>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2 generate" style="display: none">
        <div class="row">
            <div class="col-sm-8">
                <button type="submit" class="btn btn-primary form-control">
                    <?php echo Yii::t('app', 'Collect'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2 by-products" style="display: none">
        <div>
            <a href="#" onclick="selectProduct()" style="margin-top:5px;display: block;"><?php echo Yii::t('app', 'By Products'); ?></a>
        </div>
        <div id="showProducts"></div>
    </div>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2 show-ware" style="display: none">
        <input type="checkbox" <?php if(@$_GET['show-ware']){ echo 'checked';}; ?> name="show-ware" value="1" id="ware"> <label class="ml-1"  for="ware"><?php echo Yii::t('app', 'By warehouses'); ?></label>
    </div>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2 show-series" style="display: none">
        <input type="checkbox" <?php if(@$_GET['show-series']){ echo 'checked';}; ?> name="show-series" id="series" value="1"><label class="ml-1" for="series"><?php echo Yii::t('app', 'By series'); ?></label>
    </div>

</form>

<div id="result_block"></div>
<div id="result_block_info"></div>
</div>
<?php endif; ?>
<script>
    function hideAll() {
        $('.warehouse-type').hide();
        $('.start').hide();
        $('.end').hide();
        $('.generate').hide();
        $('.by-products').hide();
        $('.show-ware').hide();
        $('.show-series').hide();
    }
    function reportStatusChanged(val) {
        hideAll();

        if (val) {
            $('.generate').show();
            $('.show-ware').show();
            $('.show-series').show();
            $('.by-products').show();
        }
        if (val === 1) {
            $('.start').show();
            $('.end').show();
        } else if (val === 2) {
            $('.warehouse-type').show();
        }
    }

</script>