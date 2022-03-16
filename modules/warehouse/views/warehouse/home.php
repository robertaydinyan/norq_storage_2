<?php

use app\modules\warehouse\models\WarehouseSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Warehouse');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="group-product-index d-flex align-items-center justify-content-between">

    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?> </h1>
    <div class="mr-5">
        <div class="input-group rounded mb-3">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
              </span>
        </div>
        <div class="d-flex">
                 <div class="dropdown mr-2 btn-drop">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-filter mr-2"></i>Фильтры<i class="fa fa-caret-down ml-2"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                 </div>
<?php if(\app\rbac\WarehouseRule::can('product', 'show-log')): ?>

<?php endif; ?>
            <div class="dropdown mr-2 btn-drop">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bars mr-2"></i> Dropdown button<i class="fa fa-caret-down ml-2"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            <div class="dropdown btn-drop">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-star mr-2"></i> Dropdown button<i class="fa fa-caret-down ml-2"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
    </div>

</div>
<div class=" warehouse-home mt-5  " >
     <div class="warehouse-home-item mb-3">
            <div class="widget widget-card-two">
                <div class="widget-content">

                    <div class="media p-4 align-items-center border-bottom" >
                        <div class="media-body">
                            <div class="media align-items-center">
                                <div class="w-img">
                                    <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                                </div>
                                <div class="media-body">
                                    <h3><?=   Yii::t('app', 'Main warehouse') ?><h3>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-bottom-section mt-5">
                        <div> <a href="/warehouse/warehouse/view?id=20&lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                    </div>
                </div>
            </div>
            </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Warehouses') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/warehouse?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'goods') ?></h3>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a  href="/warehouse/product?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Documents') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/shipping-request/documents?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Polls') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/shipping-request?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Directory') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/qty-type?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Reports') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/reports?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Composition') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/complectation?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Payments') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/payments?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="warehouse-home-item mb-3">
        <div class="widget widget-card-two">
            <div class="widget-content">

                <div class="media p-4 align-items-center border-bottom" >
                    <div class="media-body">
                        <div class="media align-items-center">
                            <div class="w-img">
                                <i class="fas fa-user-injured" style="color: #1b55e2;font-size: 46px;"></i>
                            </div>
                            <div class="media-body">
                                <h3><?=   Yii::t('app', 'Users') ?></h3>
                            </div>
                            <div class="w-img text-right">
                                <div class="w-img text-right">
                                    <h2 style="color: #1b55e2;font-weight: bold">
                                        <div class="dropdown mr-2 btn-drop">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Dropdown button<i class="fa fa-caret-down ml-2"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton5">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                            </div>
                                        </div>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-bottom-section mt-5">
                    <div> <a href="/warehouse/users?lang=<?= $lang ?>" class="btn  text-white see mb-3">Դիտել</a></div>
                </div>
            </div>
        </div>
    </div>

</div>



<script type="text/javascript">
    $('.show-modal').click(function(){
        var href = $(this).attr('data-modal');
        var html_ = $('#page-modal').html();

        $('.modal-content-custom').append(html_);
        $('.modal-content-custom').show().animate({left: '10%'}, {duration: 600});
        $('.modal-content-custom .close').click(function(){
            $('.modal-content-custom').animate({left: '110%'}, {duration: 600});
            $('.modal-content-custom .page1').remove();
        });
    });

</script>