<table class="table table-hover">
    <thead>
      <tr>
          <th>ID</th>
          <th>Ապրանք</th>
          <th>Սերիա</th>
          <th>Քանակ</th>
          <th>Գին</th>
          <th>Ամսաթիվ</th>
          <th>Ընդ․</th>
      </tr>
    </thead>
    <?php if(!empty($products)){?>
    <tbody>

           <?php foreach ($products as $product => $prod_val){?>
            <?php if(!$prod_val->count){ continue; } ?>
           <tr>
               <td><?php echo $prod_val->id;?></td>
               <td><a href="#" onclick="showLog('<?php echo $prod_val->id;?>')" ><?php echo $prod_val->nProduct->name_hy;?></a></td>
               <td><?php echo $prod_val->mac_address;?></td>
               <td><?php echo $prod_val->count;?></td>
               <td><?php echo $prod_val->price;?> դր․</td>
               <td><?php echo date('d.m.Y',strtotime($prod_val->created_at));?> դր․</td>
               <td><?php echo $prod_val->price*$prod_val->count;?> դր․</td>
           </tr>
           <?php } ?>

    </tbody>
    <?php } ?>
</table>