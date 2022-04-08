<?php
use app\modules\warehouse\models\Warehouse;
use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\WarehouseSearch;
use app\modules\warehouse\models\ShippingRequest;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Warehouse'), 'Warehouse');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title[0];
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<?php if(!empty($_GET['search'])){ ?>
    <style>
        .card-bottom-section{
            display: none;
        }
    </style>
<?php } else {
    unset($_GET['search']);
} ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="mr-5 mt-4  d-flex flex-wrap justify-content-between" >

    <div class="d-flex">
      <!--   <div class="dropdown mr-2 btn-drop">
            <button class="btn btn-secondary dropdown-toggle bg-white bg-white" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars mr-2"></i> <?= Yii::t('app','History') ?> <i class="fa fa-caret-down ml-2"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <?php if (isset($history)):
                    foreach ($history as $h): ?>
                        <a class="dropdown-item" href="<?php echo $h->link; ?>"><?php echo $h->title . " " . date("m/d/Y H:i:s", $h->time); ?></a>
                    <?php endforeach;
                endif; ?>
            </div>
        </div>
        <div class="dropdown btn-drop">
            <button class="btn btn-secondary dropdown-toggle bg-white bg-white" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-star mr-2"></i> <?= Yii::t('app','Favorite') ?> <i class="fa fa-caret-down ml-2"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                <?php if (isset($favorites)):
                    foreach ($favorites as $f): ?>
                        <a class="dropdown-item" href="<?php echo $f->link; ?>"><?php echo yii::t('app',$f->title); ?></a>
                    <?php endforeach;
                endif; ?>
            </div>
        </div> -->
    </div>
</div>

<!--<div class="group-product-index d-flex align-items-center justify-content-between">
    <h1 style="padding: 20px;" class="show-modal" data-title="<?php /*echo $this->title[1]; */?>"><?/*= Html::encode($this->title[0]) */?> </h1>


</div>-->
<div class=" warehouse-home mt-3  " >
    <?php if (\app\rbac\WarehouseRule::can('warehouse', 'view')): ?>
     <div class="warehouse-home-item mb-3">
            <div class="widget widget-card-two">
                <div class="widget-content">

                    <div class="media  p-4 align-items-center border-bottom" >
                        <div class="media-body">
                            <div class="media border-right-blue align-items-center">
                                <div class="w-img">
                                    <i class='fas fa-warehouse mr-2'  style="color:#0055a5;font-size: 35px;"></i>
                                </div>
                                <div class="media-body">
                                    <h3 class=""><?= Yii::t('app', 'Main warehouse') ?><h3>
                                </div>
                            </div>
                        </div>
                      
                    </div>

                    <div class="card-bottom-section mt-5">
                         
                        <div> <a href="/warehouse/warehouse/view?id=20&lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                    </div>
                </div>
            </div>
            </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('warehouse', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class='fas fa-shipping-fast mr-2'  style="color:#0055a5;font-size: 35px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Warehouses') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>
                  <div style="padding-left:20px;max-height: 200px;overflow:auto;">
                      <?php if(isset($_GET['search'])){ 
                            $warehouses = Warehouse::find()->where(['LIKE','name_'.$lang,$_GET['search']])->all();
                            if(!empty($warehouses)){
                                foreach($warehouses as $warehouse_ => $warehouse_val){
                                     echo '<a target="_blank" href="/warehouse/warehouse/view?id='.$warehouse_val->id.'&lang=">'.$warehouse_val->{'name_'.$lang}.'</a><br>';
                                }
                            }
                         } ?>
                    </div>
                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/warehouse?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('product', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class='fas fa-box-open mr-2' style="color:#0055a5;font-size: 40px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'goods') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>
                 <div style="padding-left:20px;max-height: 200px;overflow:auto;">
                      <?php if(isset($_GET['search'])){ 
                            $products = Product::findByData($_GET);
                            if(!empty($products)){
                                foreach($products as $product_ => $product_val){
                                    if($product_val['pcount']){
                                     echo '<a target="_blank" href="/warehouse/warehouse/view?id='.$product_val['wid'].'&lang=">'.$product_val['wname'].'-'.$product_val['name_'.$lang].'( '.$product_val['pcount'].$product_val['qty_type'].')</a><br>';
                                    }
                                }
                            }
                         } ?>
                    </div>
                <div class="card-bottom-section mt-5">
                    <div> <a  href="/warehouse/product?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('shippingRequest', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class="fa fa-file-text mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Documents') ?></h3>
                            </div>

                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color:#0055a5;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle bg-white" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?=   Yii::t('app', 'Menu') ?><i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <nav id="w5" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
                                                    <div id="w5-collapse" class="collapse navbar-collapse">
                                                        <ul id="w5" class="navbar-nav w-100 nav">
                                                            <?php $uri = explode('?',$_SERVER['REQUEST_URI']); ?>
                                                            <li class="nav-item dropdown-item"><a class="nav-link <?php if(!isset($_GET['type'])){ echo 'active';} ?>" href="<?php echo '/warehouse/shipping-request/documents' . '?lang=' . \Yii::$app->language; ?>"><?php echo Yii::t('app', 'All'); ?></a></li>
                                                            <?php foreach ($shipping_types as $shp_type => $shp_type_val){ ?>
                                                                <li class="nav-item dropdown-item"><a class="nav-link <?php if(isset($_GET['type']) && ($_GET['type']==$shp_type_val->id)){ echo 'active';} ?>" href="/warehouse/shipping-request/documents?type=<?php echo $shp_type_val->id;?>&lang=<?php echo \Yii::$app->language; ?>"><?php echo $shp_type_val->{'name_' . $lang};?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                      
                </div>
                <div style="padding-left:20px;max-height: 200px;overflow:auto;">
                  <?php if(isset($_GET['search'])){ 
                        $documents = ShippingRequest::find()->where(['LIKE','comment',$_GET['search']])->andWhere(['status'=>3])->all();
                        if(!empty($documents)){
                            foreach($documents as $document_ => $document_val){
                                 echo '<a target="_blank" href="/warehouse/shipping-request/view?id='.$document_val->id.'&lang=">'.$document_val->shippingtype->{'name_'.$lang}.'</a><br>';
                            }
                        }
                     } ?>
                </div>
                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/shipping-request/documents?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('shippingRequest', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class="fas fa-poll-h mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Polls') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color:#0055a5;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle bg-white" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?=   Yii::t('app', 'Menu') ?><i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <nav id="w5" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
                                                    <div id="w5-collapse" class="collapse navbar-collapse">
                                                        <ul id="w5" class="navbar-nav w-100 nav">
                                                            <?php $uri = explode('?',$_SERVER['REQUEST_URI']); ?>
                                                            <li class="nav-item dropdown-item"><a class="nav-link <?php if(!isset($_GET['type'])){ echo 'active';} ?>" href="<?php echo '/warehouse/shipping-request/documents' . '?lang=' . \Yii::$app->language; ?>"><?php echo Yii::t('app', 'All'); ?></a></li>
                                                            <?php foreach ($shipping_types as $shp_type => $shp_type_val){ ?>
                                                                <li class="nav-item dropdown-item"><a class="nav-link <?php if(isset($_GET['type']) && ($_GET['type']==$shp_type_val->id)){ echo 'active';} ?>" href="/warehouse/shipping-request?type=<?php echo $shp_type_val->id;?>&lang=<?php echo \Yii::$app->language; ?>"><?php echo $shp_type_val->{'name_' . $lang};?></a></li>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                 <div style="padding-left:20px;max-height: 200px;overflow:auto;">
                  <?php if(isset($_GET['search'])){ 
                        $documents = ShippingRequest::find()->where(['LIKE','comment',$_GET['search']])->andWhere(['status'=>5])->all();
                        if(!empty($documents)){
                            foreach($documents as $document_ => $document_val){
                                 echo '<a target="_blank" href="/warehouse/shipping-request/view?id='.$document_val->id.'&lang=">'.$document_val->shippingtype->{'name_'.$lang}.'</a><br>';
                            }
                        }
                     } ?>
                </div>
                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/shipping-request?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('qtyType', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class="fa fa-newspaper mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Directory') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color:#0055a5;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle bg-white" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?=   Yii::t('app', 'Menu') ?><i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
                                                    <div id="w3-collapse" class="collapse navbar-collapse">
                                                        <ul id="w5" class="navbar-nav w-100 nav">
                                                            <li class="nav-item dropdown-item"><?php echo $this->render('/menu-home', array(), true)?></li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/qty-type?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('report', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class="far fa-file-alt mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Reports') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/reports?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('complectation', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-file-signature mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Composition') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/complectation?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('payment', 'index')): ?>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media border-right-blue align-items-center">
                            <div class="w-img">
                                <i class="fa fa-credit-card mr-2" style="color:#0055a5;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3 class=""><?=   Yii::t('app', 'Payments') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color:#0055a5;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle bg-white" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <?=   Yii::t('app', 'Menu') ?><i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
                                                    <div id="w3-collapse" class="collapse navbar-collapse">
                                                        <ul id="w5" class="navbar-nav w-100 nav">
                                                            <li class="nav-item dropdown-item"><a class="nav-link" href="/warehouse/payments?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Statistics'); ?></a></li>
                                                            <li class="nav-item dropdown-item"><a class="nav-link" href="/warehouse/payments-log?lang=<?php echo \Yii::$app->language; ?>"><?php echo Yii::t('app', 'Payments'); ?></a></li>
                                                        </ul>
                                                    </div>
                                                </nav>

                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/payments?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if (\app\rbac\WarehouseRule::can('users', 'index')): ?>
        <div class="warehouse-home-item mb-3">
            <div class="widget widget-card-two">
                <div class="widget-content">

                    <div class="media  p-4 align-items-center border-bottom" >
                        <div class="media-body">
                            <div class="media border-right-blue align-items-center">
                                <div class="w-img">
                                    <i class="fa fa-users mr-2" style="color:#0055a5;font-size: 46px;"></i>
                                </div>
                                <div class="media-body">
                                    <h3 class=""><?=   Yii::t('app', 'Users') ?></h3>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div style="padding-left:20px;max-height: 200px;overflow:auto;">
                      <?php if(isset($_GET['search'])){ 
                            $users = User::find()->where(['LIKE','name',$_GET['search']])->all();
                            if(!empty($users)){
                                foreach($users as $user_ => $user_val){
                                     echo '<a target="_blank" href="/warehouse/users/edit?id='.$user_val->id.'&lang=">'.$user_val->name.'</a><br>';
                                }
                            }
                         } ?>
                    </div>
                    <div class="card-bottom-section mt-5">
                        <div> <a href="/warehouse/users?lang=<?= $lang ?>" class="btn  text-white see mb-3"><?=   Yii::t('app', 'View') ?></a></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>





