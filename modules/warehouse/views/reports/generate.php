<?php use app\modules\warehouse\models\Product;
if(!empty($data)){ ?>
    <?php if(@$_GET['show-ware']){ $total =[]; ?>
        <?php  foreach ($data as $product => $prod_val){
            $total[$prod_val['nomenclature_product_id']]['count'] += $prod_val['pcount'];
            $total[$prod_val['nomenclature_product_id']]['total'] += $prod_val['price']*$prod_val['pcount'];
        } ?>
    <?php } ?>
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <div style="padding: 20px;">
        <table class="kv-grid-table table table-hover  kv-table-wrap" id="datatable">
            <thead>
            <tr style="background:#1b55e2;color:#fff;">
                <?php if(@$_GET['show-series']){ ?>
                    <td><?php echo Yii::t('app', 'Series');?></td>
                <?php } ?>
                <td><?php echo Yii::t('app', 'Name');?></td>
                <?php if(@$_GET['show-ware']){ ?>
                    <td><?php echo Yii::t('app', 'Warehouse');?></td>
                <?php } ?>
                 <?php if(!$_GET['from_created_at'] || !$_GET['to_created_at'] || @!$_GET['show-ware']){ ?>
                    <td><?php echo Yii::t('app', 'Count');?></td>
                <?php } ?>
                <td><?php echo Yii::t('app', 'Price');?></td>
                <td><?php echo Yii::t('app', 'General');?></td>
                <?php if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ ?>
                    <td><?php echo Yii::t('app', 'Opening balance');?></td>
                    <td><?php echo Yii::t('app', 'Login');?></td>
                    <td><?php echo Yii::t('app', 'Exit');?></td>
                    <td><?php echo Yii::t('app', 'General');?></td>
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
                <?php if(@$_GET['show-ware'] && $count_prods[$prod_val['nomenclature_product_id']]==1){  ?>
                    <tr style="background:#1b55e2;color:#fff;">
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
                    <td><?php echo $prod_val['name'];?></td>
                    <?php if(@$_GET['show-ware']){ ?>
                        <td> <?php echo $prod_val['wname'];?></td>
                    <?php } ?>
                     <?php if(!$_GET['from_created_at'] || !$_GET['to_created_at'] || @!$_GET['show-ware']){ ?>
                        <td> <?php echo $prod_val['pcount'];?> <?php echo $prod_val['qty_type'];?></td>
                    <?php } ?>
                    <td><?php echo number_format($prod_val['avgprice'],0,'.','.');?> դր</td>
                    <td><?php echo number_format($prod_val['pprice'],0,'.','.');?> դր</td>
                    <?php if($_GET['from_created_at'] && $_GET['to_created_at'] && @$_GET['show-ware'] && @!$_GET['show-series']){ ?>

                        <?php if($prod_val['warehouse_id']){ $moveData = Product::MoveData($_GET,$prod_val['nomenclature_product_id'],$prod_val['warehouse_id']);} ?>
                        <td>
                            <?php echo intval($moveData['opening']);?> <?php echo $prod_val['qty_type'];?>
                        </td>
                        <td><?php echo intval($moveData['sell_in']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td><?php echo intval($moveData['sell_out']); ?> <?php echo $prod_val['qty_type'];?></td>
                        <td><?php echo ($moveData['closing']-$moveData['sell_out']);?> <?php echo $prod_val['qty_type'];?></td>
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
                     'csv', 'excel','pdf'
                ],
                "bSort" : false,
                "paging": false,
                 "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Որոնում "
                },
            } );
       },500);
           
        </script>
<?php } ?>