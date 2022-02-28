<?php
use \app\modules\warehouse\models\Product;
use app\modules\warehouse\models\Warehouse;
use kartik\date\DatePicker;

$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/shipping_new.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>

<style>
    .select2-results__options--nested{
        padding-left: 10px;
    }
</style>
<div class="shipping-request-create group-product-index">
    <br>
<form class="row" action="" id="report_form" method="get" style="padding: 20px;">
    <div class="col-sm-12" style="margin-bottom: 10px;">
        <div class="row">
            <div class="col-sm-2">
                <select name="warehouse_type" class="form-control warehouse_type">
                    <option value="">Պահեստի տեսակ</option>
                    <?php if(!empty($warehouse_types)){
                        foreach ($warehouse_types as $warehouse =>$wh){
                            echo '<option  value="'.$warehouse.'" >'.$wh.'</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 <?php if(@!$_GET['region_id']){ echo 'hide';}?> region">
                <select name="region_id" class="form-control region_">
                    <option value="">Շրջան</option>
                    <?php if(!empty($regions)){
                        foreach ($regions as $region =>$rg){
                            echo '<option  value="'.$region.'" >'.$rg.'</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 hide subgroup">
                <select name="virtual_type" <?php if(@!$_GET['virtual_type']){ echo 'hide';}?> class="form-control virtual_type">
                    <option value="">Վիրտուալ (տեսակներ)</option>
                    <?php if(!empty($groups)){
                        foreach ($groups as $group =>$gr){
                            echo '<option  value="'.$group.'" >'.$gr.'</option>';
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 <?php if(@!$_GET['community_id']){ echo 'hide';}?> community">
                <select name="community_id" class="form-control community_select">
                    <option value="">Համայնք</option>
                </select>
            </div>
            <div class="col-sm-2 hide ware" <?php if(@!$_GET['supplier_warehouse_id']){ echo 'hide';}?>>
                <select name="supplier_warehouse_id" class="form-control ware_select">
                    <option value="">Պահեստ</option>
                </select>
            </div>
            <div class="col-sm-2">
                 <?php 
                    echo DatePicker::widget([
                        'name' => 'from_created_at', 
                        'value' => $_GET['from_created_at'],
                        'options' => ['placeholder' => 'սկիզբ'],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
                            'todayHighlight' => true
                        ]
                    ]);
                    ?>
               
            </div>
            <div class="col-sm-2">
                <?php 
                    echo DatePicker::widget([
                        'name' => 'to_created_at', 
                        'value' => $_GET['to_created_at'],
                        'options' => ['placeholder' => 'ավարտ'],
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
    <div class="col-sm-2">
        <div class="row">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary form-control">
                    Հավաքել
                </button>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div>
            <a href="#" onclick="selectProduct()" style="margin-top:5px;display: block;">Ըստ Ապրանքների</a>
        </div>
        <div id="showProducts"></div>
    </div>
    <div class="col-sm-2">
        <input type="checkbox" <?php if(@$_GET['show-ware']){ echo 'checked';}; ?> name="show-ware" value="1" id="ware"> <label class="ml-1"  for="ware">Ըստ պահեստների</label>
    </div>
    <div class="col-sm-2">
        <input type="checkbox" <?php if(@$_GET['show-series']){ echo 'checked';}; ?> name="show-series" id="series" value="1"><label class="ml-1" for="series">Ըստ սերաների</label>
    </div>

</form>

<div id="result_block"></div>
</div>
