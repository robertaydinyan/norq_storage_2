<?php
?>
<table class="table table-striped">

    <thead>
        <th><input type="checkbox" class="select_all" class="form-check-input"></th>
        <th>Անվանում</th>
        <th>Սերիա</th>
    </thead>
    <tbody>
        <?php
        if(!empty($products)) {
            foreach ($products as $product => $prod_val) { ?>
               <tr>
                    <td><input type="checkbox" data-mac="<?php echo $prod_val->mac_address;?>" value="<?php echo $prod_val->nProduct->name;?>" class="form-check-input chks"></td>
                    <td><?php echo $prod_val->nProduct->name;?></td>
                    <td><?php echo $prod_val->mac_address;?></td>
               </tr>
            <?php   }
        }
        ?>
    </tbody>
</table>
