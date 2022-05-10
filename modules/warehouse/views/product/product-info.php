
<table class="table table-striped">

    <thead>
        <th>Պահեստ</th>
        <th>Անվանում</th>
        <th>Քանակ</th>
        <th>Չմ</th>
    </thead>
    <tbody>
        <?php
        if(!empty($products)) {
            foreach ($products as $product => $prod_val) { ?>
               <tr>
                    <td><?php echo $prod_val->warehouse->name;?></td>
                    <td><a href="#" data-toggle="modal" data-target="#viewInfoP" onclick="showInfoP(<?php echo $prod_val->nProduct->id;?>,<?php echo $prod_val->warehouse->id;?>)"><?php echo $prod_val->nProduct->name;?></a></td>
                    <td><?php echo $prod_val->count;?> </td>
                    <td><?php echo $prod_val->nProduct->qtyType->type;?></td>
               </tr>
            <?php   }
        }
        ?>
    </tbody>
</table>
<script>
    function showInfoP(id, wid) {
        if (id) {
            $.ajax({
                url: '/warehouse/warehouse/get-product-info',
                method: 'get',
                dataType: 'html',
                data: {id: id, wid: wid},
                success: function (data) {
                    $('.mod-content').html(data);
                }
            });
        }
    }
</script>
<div class="modal fade" id="viewInfoP" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="mod-content"></div>
            </div>
        </div>

    </div>
</div>