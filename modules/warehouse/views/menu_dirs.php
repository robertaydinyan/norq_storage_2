<nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <div id="w3-collapse" class="collapse navbar-collapse">
        <ul id="w5" class="navbar-nav w-100 nav">
            <li class="nav-item "><a class="nav-link" href="/warehouse/qty-type?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Unit of measurement'); ?></a></li>
<!--            <li class="nav-item"><a class="nav-link" href="/warehouse/shipping-type?lang=<?php /*echo \Yii::$app->language; */?>"><?php /*echo Yii::t('app', 'Type of transfer'); */?></a></li>
-->  <!--          <li class="nav-item"><a class="nav-link" href="/warehouse/status-list?lang=<?php /*echo \Yii::$app->language; */?>"><?php /*echo Yii::t('app', 'Statuses'); */?></a></li>
-->          <!--  <li class="nav-item"><a class="nav-link" href="/warehouse/warehouse-types?lang=<?php /*echo \Yii::$app->language; */?>"><?php /*echo Yii::t('app', 'Warehouse types'); */?></a></li>-->
            <li class="nav-item"><a class="nav-link" href="/warehouse/warehouse-groups?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Virtual (types)'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="/warehouse/suppliers-list?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'co-workers'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="/warehouse/group-product?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Product group'); ?></a></li>
            <li class="nav-item"><a class="nav-link" href="/warehouse/nomenclature-product?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Product Nomenclature'); ?></a></li>
        </ul>
    </div>
</nav>







<!--

controller


use app\components\Url;

use app\modules\warehouse\models\Favorite;


$isFavorite = Favorite::find()->where(['user_id' => Yii::$app->user->id, 'link' => URL::current()])->count() == 1;


return

'isFavorite' => $isFavorite,

 view


<span class="star" ><i class="fa <?php /*echo $isFavorite ? 'fa-star' : 'fa-star-o' */?> ml-4"></i></span>


-->