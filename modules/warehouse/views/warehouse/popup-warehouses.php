<?php 
use app\modules\warehouse\models\WarehouseTypes;
use app\modules\billing\models\Regions;
use app\modules\warehouse\models\WarehouseGroups;
use yii\helpers\ArrayHelper;
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
$warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()->all(), 'id','name_' . $lang);
$regions = ArrayHelper::map(Regions::find()->asArray()->all(), 'id', 'name');
$groups = ArrayHelper::map(WarehouseGroups::find()->asArray()->all(), 'id', 'name_' . $lang);
?>
<div class="modal fade" id="viewInfoWr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="mod-content">
                    <div class="col-sm-12">
                        <select name="warehouse_type" class="form-control warehouse_type">
                                <option value=""><?php echo Yii::t('app', 'Warehouse type'); ?></option>
                                <?php if(!empty($warehouse_types)){
                                    foreach ($warehouse_types as $warehouse =>$wh){
                                        echo '<option  value="'.$warehouse.'" >'.$wh.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>
<!--                        <div class="col-sm-12 hide region">-->
<!--                            <select name="region_id" class="form-control region_">-->
<!--                                <option value="">--><?php //echo Yii::t('app', 'District'); ?><!--</option>-->
<!--                                --><?php //if(!empty($regions)){
//                                    foreach ($regions as $region =>$rg){
//                                        echo '<option  value="'.$region.'" >'.$rg.'</option>';
//                                    }
//                                } ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12 hide subgroup">-->
<!--                            <select name="virtual_type"  class="form-control virtual_type">-->
<!--                                <option value="">--><?php //echo Yii::t('app', 'Virtual (types)'); ?><!--</option>-->
<!--                                --><?php //if(!empty($groups)){
//                                    foreach ($groups as $group =>$gr){
//                                        echo '<option  value="'.$group.'" >'.$gr.'</option>';
//                                    }
//                                } ?>
<!--                            </select>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12 hide community">-->
<!--                            <select name="community_id" class="form-control community_select">-->
<!--                                <option value="">--><?php //echo Yii::t('app', 'Community'); ?><!--</option>-->
<!--                            </select>-->
<!--                        </div>-->
                        <div class="col-sm-12 hide ware">
                            <select name="supplier_warehouse_id" onchange="setWarehouse($(this).val(),$(this).find('option:selected').text())" class="form-control ware_select">
                                <option value=""><?php echo Yii::t('app', 'Warehouse'); ?></option>
                            </select>
                        </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#viewInfoWr').modal('show');

</script>
<style>
    .col-sm-12{
        margin-bottom: 10px;
    }
</style>