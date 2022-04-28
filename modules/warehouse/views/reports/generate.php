<?php use app\modules\warehouse\models\Product;
if(!empty($data)){ ?>
    <?php if(@$_GET['show-ware']){ $total =[]; ?>
        <?php  foreach ($data as $product => $prod_val){
            $total[$prod_val['nomenclature_product_id']]['count'] += $prod_val['pcount'];
            $total[$prod_val['nomenclature_product_id']]['total'] += $prod_val['price']*$prod_val['pcount'];
        } ?>
    <?php } ?>

    <div style="padding: 20px;">

        <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap" id="datatable">
            <thead>
            <tr style="background:#0055a5!important;color:#fff;">
                <?php if(@$_GET['show-series']){ ?>
                    <td>Սերիա</td>
                <?php } ?>
                <td>Անվանում</td>
                <?php if(@$_GET['show-ware']){ ?>
                    <td>Պահեստ</td>
                <?php } ?>
                 <?php if(!$_GET['from_created_at'] || !$_GET['to_created_at'] || @!$_GET['show-ware']){ ?>
                    <td>Քանակ</td>
                <?php } ?>
                <td>Գին</td>
                <td>Ընդ</td>
                <?php if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ ?>
                    <td>Սկզբնական մնացորդ</td>
                    <td>Մուտք</td>
                    <td>Ելք</td>
                    <td>Վերջնական մնացորդ</td>
                <?php } ?>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($data as $product => $prod_val){
                if(!isset($count_prods[$prod_val['nomenclature_product_id']])){
                    $count_prods[$prod_val['nomenclature_product_id']] = 0;
                }
                $count_prods[$prod_val['nomenclature_product_id']] +=1;
                ?>
                <?php 
                if($prod_val['warehouse_id']){
                  $moveData = Product::MoveData($_GET,$prod_val['nomenclature_product_id'],$prod_val['warehouse_id']);
                      if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ 
                             if($moveData['opening'] == 0 && intval($moveData['sell_in']) == 0 && $moveData['sell_out'] == 0 && $moveData['closing'] == 0){
                                continue;
                             }
                      } 
                } 
                ?>

                <?php if(@$_GET['show-ware'] && $count_prods[$prod_val['nomenclature_product_id']]==1){  ?>
                    <tr style="background:#0055a5 !important;color:#fff;">
                        <?php if(@$_GET['show-series']){ ?>
                            <td></td>
                        <?php } ?>
                        <td><?php echo $prod_val['name'];?></td>
                        <td></td>
                            <?php if(!$_GET['from_created_at'] || !$_GET['to_created_at'] || @!$_GET['show-ware']){ ?>
                        <td><?php echo $total[$prod_val['nomenclature_product_id']]['count'];?> <?php echo $prod_val['qty_type'];?></td>
                        <?php } ?>
                        <td></td>
                        
                    
                        <td></td>

                        <?php if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <?php if(@$_GET['show-series']){ ?>
                        <td onclick="showLog('<?php echo $prod_val['mac'];?>')"><a href="javascript:void(0)" ><?php echo $prod_val['mac'];?></a></td>
                    <?php } ?>
                    <td><a href="#" onclick="showPage('/warehouse/nomenclature-product/view?id=<?php echo $prod_val['nomenclature_product_id'];?>','<?php echo $prod_val['name'];?>')"><?php echo $prod_val['name'];?></a></td>
                    <?php if(@$_GET['show-ware']){ ?>
                        <td><a href="#" onclick="showPage('/warehouse/warehouse/view?id=<?php echo $prod_val['warehouse_id'];?>','<?php echo $prod_val['wname'];?>')"><?php echo $prod_val['wname'];?></a></td>
                    <?php } ?>
                     <?php if(!$_GET['from_created_at'] || !$_GET['to_created_at'] || @!$_GET['show-ware']){ ?>
                        <td> <?php echo $prod_val['pcount'];?> <?php echo $prod_val['qty_type'];?></td>
                    <?php } ?>
                    <td><?php echo number_format($prod_val['avgprice'],0,'.','.');?> դր</td>
                    <td><?php echo number_format($prod_val['pprice'],0,'.','.');?> դր</td>
                    <?php if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ ?>

                      <?php if($prod_val['individual'] == 'true'){ ?>
                        <td style="cursor:pointer;" onclick="showOpening(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)">
                            <?php echo intval($moveData['opening']);?> <?php echo $prod_val['qty_type'];?>
                        </td>
                        <td style="cursor:pointer;" onclick="showSellIn(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)"><?php echo intval($moveData['sell_in']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td style="cursor:pointer;" onclick="showSellOut(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)"><?php echo intval($moveData['sell_out']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td style="cursor:pointer;" onclick="showClosing(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)"><?php echo ($moveData['closing']);?> <?php echo $prod_val['qty_type'];?></td>
                      <?php } else { ?>
                         <td>
                            <?php echo intval($moveData['opening']);?> <?php echo $prod_val['qty_type'];?>
                        </td>
                        <td style="cursor:pointer;" onclick="showSellIn(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)"><?php echo intval($moveData['sell_in']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td style="cursor:pointer;" onclick="showSellOut(<?php echo $prod_val['nomenclature_product_id'];?>,<?php echo $prod_val['warehouse_id'];?>)"><?php echo intval($moveData['sell_out']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td><?php echo ($moveData['closing']);?> <?php echo $prod_val['qty_type'];?></td>
                      <?php } ?>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
  
   <script>
       setTimeout(function(){
           $('#datatable').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel','print'
                ],
                "bSort" : false,
                "paging": false,
                 "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Որոնում "
                },
            } );
       },500);
              function showSellOut(nomeclature_id,wid){
                $.ajax({
                    type: 'get',
                    url: '/warehouse/reports/generate-sellout',
                    data: $('form').serialize()+ "&nomeclature_id=" + nomeclature_id+"&wid="+wid,
                    success: function (data) {
                        $('#result_block_info').html(data);
                    }
                });
            }
            function showSellIn(nomeclature_id,wid){
                $.ajax({
                    type: 'get',
                    url: '/warehouse/reports/generate-sellin',
                    data: $('form').serialize()+ "&nomeclature_id=" + nomeclature_id+"&wid="+wid,
                    success: function (data) {
                        $('#result_block_info').html(data);
                    }
                });
            }
             function showOpening(nomeclature_id,wid){
                $.ajax({
                    type: 'get',
                    url: '/warehouse/reports/generate-opening',
                    data: $('form').serialize()+ "&nomeclature_id=" + nomeclature_id+"&wid="+wid,
                    success: function (data) {
                        $('#result_block_info').html(data);
                    }
                });
            }
            function showClosing(nomeclature_id,wid){
                $.ajax({
                    type: 'get',
                    url: '/warehouse/reports/generate-closing',
                    data: $('form').serialize()+ "&nomeclature_id=" + nomeclature_id+"&wid="+wid,
                    success: function (data) {
                        $('#result_block_info').html(data);
                    }
                });
            }
        </script>
<?php } ?>