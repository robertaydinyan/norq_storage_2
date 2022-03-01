<table class="table table-hover">
    <thead>
      <tr>
          <th>ID</th>
          <th>Ապրանք</th>
          <th>Քանակ</th>
          <th>Ինդիվիդուալ</th>
      </tr>
    </thead>
    <?php if(!empty($products)){?>
    <tbody>

           <?php foreach ($products as $product => $prod_val){?>
           <tr>
               <td><?php echo $prod_val['id'];?></td>
               <td><?php echo $prod_val['name'];?></td>
               <td><?php echo $prod_val['count'];?> <?php echo $prod_val['qty_type'];?></td>
               <td><?php if($prod_val['individual'] == 'true'){ echo $prod_val['mac'];} ?></td>
           </tr>
           <?php } ?>

    </tbody>
    <?php } ?>
</table>
