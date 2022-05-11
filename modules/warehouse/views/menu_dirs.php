<?php
use yii\helpers\Url;

?>
<nav id="w4" class="main-header navbar-expand bg-white navbar-light border-bottom">
    <div id="w3-collapse" class="collapse navbar-collapse">
        <ul id="w5" class="navbar-nav w-100 nav">
            <li class="nav-item "><a class="nav-link" href="<?php echo URL::to('/warehouse/qty-type'); ?>"><?php echo Yii::t('app', 'Unit of measurement'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/currency'); ?>"><?php echo Yii::t('app', 'Currency'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/warehouse-groups'); ?>"><?php echo Yii::t('app', 'Virtual (types)'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/suppliers-list'); ?>"><?php echo Yii::t('app', 'co-workers'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/group-product'); ?>"><?php echo Yii::t('app', 'Product group'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/nomenclature-product'); ?>"><?php echo Yii::t('app', 'Product Nomenclature'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/analogs'); ?>"><?php echo Yii::t('app', 'Analogs'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/manufacturer'); ?>"><?php echo Yii::t('app', 'Manufacturers'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/vat'); ?>"><?php echo Yii::t('app', 'Vat'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo URL::to('/warehouse/expenditure-article'); ?>"><?php echo Yii::t('app', 'Expenditure Article'); ?></a></li>
        </ul>
    </div>
</nav>