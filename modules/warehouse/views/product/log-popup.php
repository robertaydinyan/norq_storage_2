<div class="modal fade" id="viewInfoLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="mod-content"><table class="table table-hover">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Տեսակ</th>
                            <th>Որտեղից</th>
                            <th>Ուր</th>
                            <th>Ամսաթիվ</th>
                            <th>Փաստաթուղտ</th>
                        </tr>
                        </thead>
                        <?php if(!empty($logs)){?>
                            <tbody>

                            <?php foreach ($logs as $log => $log_val){?>
                                <?php $type = \app\modules\warehouse\models\ShippingType::findOne(['id'=>$log_val['shipping_type']]);?>
                              
                                <tr>
                                    <td><?php echo $log_val['id'];?></td>
                                    <td><?php echo $type->name_hy;?></td>
                                    <td><?php echo $log_val['from_'];?></td>
                                    <td><?php echo $log_val['to_'];?></td>
                                    <td><?php echo date('d.m.Y',strtotime($log_val['date_create']));?></td>
                                    <td><a target="_blank" href="/warehouse/shipping-request/view?id=<?php echo $log_val['request_id'];?>"><?php echo $type->name_hy;?></a></td>
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
    $('#viewInfoLog').modal('show');
</script>
