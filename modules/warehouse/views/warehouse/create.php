<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $address app\modules\warehouse\models\Warehouse */
/* @var $dataUsers app\modules\warehouse\models\Warehouse */
/* @var $warehouse_types app\modules\warehouse\models\Warehouse */

$this->title = array(Yii::t('app', 'Create Warehouse'),'Create Warehouse');
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index form-data">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'dataUsers'=>$dataUsers,
        'address' => $address,
        'warehouse_types' => $warehouse_types,
        'warehouse_groups' => $warehouse_groups,
        'type' => 'create'

    ]) ?>
    </div>
</div>





<button style="position: fixed; bottom: 70px;right: 20px;color: #fff;"  class="show-modal"   data-modal='page-modal'>Slider</button>
<ul class="nav">
    <li class="d-flex ">
        <div class="modal-content-custom">
            <div class="close"><i class="fa fa-close"></i></div>

        </div>
    </li>
</ul>
<div class="modal-content-custom">
    <div class="close"><i class="fa fa-close"></i></div>

    <!--<section class="regular slider" style="width: 80%;margin: auto;text-align: center;height: 100%">
        <div >
            <div class="text">
                <div style="width: 95%;min-height: 200px;background: #fff;border: 10px solid #007bff;border-top:20px solid #007bff;margin-top: 50px;border-radius: 20px;position:relative;">
                    <button class="mt-3" style="color: #fff">Հաշվետվություններ</button>
                    <h1 style="text-align: center;padding-left: 20px;" class="d-flex align-items-center justify-content-center mt-5">
                        <i class="fas fa-warehouse mr-3" style="color: #1b55e2;font-size: 35px;"></i>Հաշվետվություններ
                    </h1>
                    <i class="fa fa-times" style="color: #710909;font-size: 24px;position: absolute;top: 0px;right: 3px;"></i>
                </div>
            </div>
        </div>
        <div >
            <div class="text">
                <div style="width: 95%;min-height: 200px;background: #fff;border: 10px solid #007bff;border-top:20px solid #007bff;margin-top: 50px;border-radius: 20px;position:relative;">
                    <button class="mt-3" style="color: #fff">Հաշվետվություններ</button>
                    <h1 style="text-align: center;padding-left: 20px;" class="d-flex align-items-center justify-content-center mt-5">
                        <i class="fas fa-warehouse mr-3" style="color: #1b55e2;font-size: 35px;"></i>Հաշվետվություններ
                    </h1>
                    <i class="fa fa-times" style="color: #710909;font-size: 24px;position: absolute;top: 0px;right: 3px;"></i>
                </div>
            </div>
        </div>
        <div >
            <div class="text">
                <div style="width: 95%;min-height: 200px;background: #fff;border: 10px solid #007bff;border-top:20px solid #007bff;margin-top: 50px;border-radius: 20px;position:relative;">
                    <button class="mt-3" style="color: #fff">Հաշվետվություններ</button>
                    <h1 style="text-align: center;padding-left: 20px;" class="d-flex align-items-center justify-content-center mt-5">
                        <i class="fas fa-warehouse mr-3" style="color: #1b55e2;font-size: 35px;"></i>Հաշվետվություններ
                    </h1>
                    <i class="fa fa-times" style="color: #710909;font-size: 24px;position: absolute;top: 0px;right: 3px;"></i>
                </div>
            </div>
        </div>
        <div >
            <div class="text">
                <div style="width: 95%;min-height: 200px;background: #fff;border: 10px solid #007bff;border-top:20px solid #007bff;margin-top: 50px;border-radius: 20px;position:relative;">
                    <button class="mt-3" style="color: #fff">Հաշվետվություններ</button>
                    <h1 style="text-align: center;padding-left: 20px;" class="d-flex align-items-center justify-content-center mt-5">
                        <i class="fas fa-warehouse mr-3" style="color: #1b55e2;font-size: 35px;"></i>Հաշվետվություններ
                    </h1>
                    <i class="fa fa-times" style="color: #710909;font-size: 24px;position: absolute;top: 0px;right: 3px;"></i>
                </div>
>>>>>>> 39c5218e64b1abedf74ccf59cdd3df00e0cf0376
            </div>
        </div>


    </section>-->



    <ul style="list-style: none">
        <li class="mt-2 slider slider-template">
            <i class="fas fa-warehouse mr-3" style="color: #1b55e2;font-size:20px;"></i>
            <a href="#">
                Հաշվետվություններ
            </a>
            <i class="fa fa-times ml-3 remove-slider" style="color: #710909;font-size: 20px;"></i>
        </li>
     </ul>

<!--    <section class="regular slider">-->
<!--        <div class="slider ">-->
<!--            <div class="hover"></div>-->
<!--            <div class="text">-->
<!--                <button style="background: #ca85ca;">Environment</button>-->
<!--                <span class="">remove</span>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!---->
<!--    </section>-->
</div>



<style type="text/css">
    .slick-prev,.slick-next{
        background: #007bff;
        color: #fff;
        z-index: 200;
    }
    .modal-content-custom{
        display: none;
        width: 90%;
        height: 30%;
        position: fixed;
        top: 70%;
        bottom: 0px;
        left: 110%;
        background: white !important;
        z-index: 100000;
        box-shadow: 2px 2px 2px 2px lightgray;
        /*   transition-duration: 500ms;*/

    }
    .modal-content-custom .page1{
        width: 50% !important;
        padding: 30px;
        max-height: 100vh;
        overflow: auto;
    }
    .modal-content-custom .close{
        position: absolute;
        top: 10%;
        left: -60px;
        min-width: 60px;
        border-radius: 20px 0px 0px 20px;
        color: white;
        background: rgb(47,198,246);
        cursor: pointer;
        padding: 5px 5px 5px 15px;

    }
</style>

