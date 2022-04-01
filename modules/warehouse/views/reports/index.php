<?php
use \app\modules\warehouse\models\Product;
use app\modules\warehouse\models\Warehouse;
use kartik\date\DatePicker;
use yii\helpers\Html;

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/shipping_new.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->title = array(Yii::t('app', 'Reports'),'Reports');
$this->params['breadcrumbs'][] =  $this->title[0];
?>

<style>
    .select2-results__options--nested{
        padding-left: 10px;
    }
</style>

<?php if(\app\rbac\WarehouseRule::can('reports', 'index')): ?>

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
<div class="shipping-request-create group-product-index">
    <br>
<form class="row" action="" id="report_form" method="get" style="padding: 20px;">
    <input type="hidden" name="lang" value="<?php echo Yii::$app->language; ?>">
    <div class="col-sm-12" style="margin-bottom: 10px;">
        <div class="row">
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 ">
                <select name="warehouse_type" class="form-control warehouse_type btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Warehouse type'); ?></option>
                    <?php if(!empty($warehouse_types)){
                        foreach ($warehouse_types as $warehouse =>$wh){
                            echo '<option  value="'.$warehouse.'" >'.$wh.'</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 <?php if(@!$_GET['region_id']){ echo 'hide';}?> region">
                <select name="region_id" class="form-control region_  btn-primary">
                    <option value=""><?php echo Yii::t('app', 'District'); ?></option>
                    <?php if(!empty($regions)){
                        foreach ($regions as $region =>$rg){
                            echo '<option  value="'.$region.'" >'.$rg.'</option>';
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
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2 hide ware" <?php if(@!$_GET['supplier_warehouse_id']){ echo 'hide';}?>>
                <select name="supplier_warehouse_id" class="form-control ware_select btn-primary">
                    <option value=""><?php echo Yii::t('app', 'Warehouse'); ?></option>
                </select>
            </div>
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2">
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
            <div class="col-12	col-sm-4	col-md-3 col-lg-3	col-xl-2">
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
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2">
        <div class="row">
            <div class="col-sm-8">
                <button type="submit" class="btn btn-primary form-control">
                    <?php echo Yii::t('app', 'Collect'); ?>
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2">
        <div>
            <a href="#" onclick="selectProduct()" style="margin-top:5px;display: block;"><?php echo Yii::t('app', 'By Products'); ?></a>
        </div>
        <div id="showProducts"></div>
    </div>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2">
        <input type="checkbox" <?php if(@$_GET['show-ware']){ echo 'checked';}; ?> name="show-ware" value="1" id="ware"> <label class="ml-1"  for="ware"><?php echo Yii::t('app', 'By warehouses'); ?></label>
    </div>
    <div class="col-12	col-sm-6	col-md-3 col-lg-3	col-xl-2">
        <input type="checkbox" <?php if(@$_GET['show-series']){ echo 'checked';}; ?> name="show-series" id="series" value="1"><label class="ml-1" for="series"><?php echo Yii::t('app', 'By series'); ?></label>
    </div>

</form>

<div id="result_block"></div>
</div>
<?php endif; ?>
