
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
                    <td><?php echo $prod_val->nProduct->name;?></td>
                    <td><?php echo $prod_val->count;?> </td>
                    <td><?php echo $prod_val->nProduct->qtyType->type;?></td>
               </tr>
            <?php   }
        }
        ?>
    </tbody>
</table>
