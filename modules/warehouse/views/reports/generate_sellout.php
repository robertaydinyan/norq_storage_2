<div class="modal fade" id="viewInfoLog__" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="mod-content"><table class="table table-striped table-bordered">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Սերիա</th>
                            <th>Փաստաթուղտ</th>
                            <th>Որտեղից</th>
                            <th>Ուր</th>
                            <th>Քանակ</th>
                            <th>Մեկնաբանություն</th>
                            <th>Ամսաթիվ</th>
                        </tr>
                        </thead>
                        <?php if(!empty($data)){?>
                            <tbody>

                            <?php foreach ($data as $log => $log_val){?>
                                <?php
                                 
                                    $type = \app\modules\warehouse\models\ShippingType::findOne(['id'=>$log_val['shipping_type']]); 
                                    
                                    $to = \app\modules\warehouse\models\Warehouse::find()->where(['id'=>$log_val['supplier_warehouse_id']])->one();
                                    if($log_val['shipping_type'] == 5 || $log_val['shipping_type'] == 6){
                                        $from = \app\modules\warehouse\models\SuppliersList::find()->where(['id'=>$log_val['supplier_id']])->one();
                                    } else {
                                        $from = \app\modules\warehouse\models\Warehouse::find()->where(['id'=>$log_val['provider_warehouse_id']])->one();
                                    }
                                ?>
                                <tr>

                                    <td><?php echo $log_val['id'];?></td>
                                    <th><a onclick="showLog('<?php echo $log_val['mac_address'];?>')" href="javascript:void(0)"><?php echo $log_val['mac_address'];?></a></td>
                                    <td><a target="_blank" href="/warehouse/shipping-request/view?id=<?php echo $log_val['id'];?>"><?php echo $type->name;?></a></td>
                                    <td><?php echo $from->name;?></td>
                                    <td><?php echo $to->name;?></td>
                                    <td><?php echo $log_val['Pcount'];?></td>
                                    <th><?php echo $log_val['comment'];?></th>
                                    <td><?php echo date('d.m.Y',strtotime($log_val['created_at']));?></td>
                                </tr>
                            <?php } ?>

                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#viewInfoLog__').modal('show');
</script>