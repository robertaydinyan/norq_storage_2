<?php 
use app\modules\warehouse\models\WarehouseTypes;
use app\modules\warehouse\models\WarehouseGroups;
use yii\helpers\ArrayHelper;
$warehouse_types = ArrayHelper::map(WarehouseTypes::find()->asArray()->all(), 'id','name');
$groups = ArrayHelper::map(WarehouseGroups::find()->asArray()->all(), 'id', 'name');
?>
<div class="modal fade" id="viewInfoWr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <div class="modal-body">
                
                <div class="mod-content">
                    <div class="col-sm-12">
                        <select name="warehouse_type" class="form-control warehouse_type btn-primary">
                                <option value=""><?php echo Yii::t('app', 'Warehouse type'); ?></option>
                                <?php if(!empty($warehouse_types)){
                                    foreach ($warehouse_types as $warehouse =>$wh){
                                        echo '<option  value="'.$warehouse.'" >'.$wh.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-12 hide subgroup">
                            <select name="virtual_type"  class="form-control virtual_type">
                                <option value=""><?php echo Yii::t('app', 'Virtual (types)'); ?></option>
                                <?php if(!empty($groups)){
                                    foreach ($groups as $group =>$gr){
                                        echo '<option  value="'.$group.'" >'.$gr.'</option>';
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-12 hide ware">
                            <select name="supplier_warehouse_id" onchange="setWarehouse($(this).val(),$(this).find('option:selected').text())" class="form-control ware_select btn-primary">
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