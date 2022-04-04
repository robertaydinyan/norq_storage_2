<?php
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
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
                    <td><input type="checkbox" data-mac="<?php echo $prod_val->mac_address;?>" value="<?php echo $prod_val->nProduct->{'name_' . $lang};?>" class="form-check-input chks"></td>
                    <td><?php echo $prod_val->nProduct->{'name_' . $lang};?></td>
                    <td><?php echo $prod_val->mac_address;?></td>
               </tr>
            <?php   }
        }
        ?>
    </tbody>
</table>
