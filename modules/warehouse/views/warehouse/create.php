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
    <p>aa</p>
    <section class="regular slider">
        <div>
            <div class="hover"></div>
            <div class="text">
                <button style="background: #ca85ca;">Environment</button>
                <h1>Making a Commitment to Environmental sustainability</h1>
                <span>4 day ago</span>
            </div>
        </div>
        <div>
            <div class="hover"></div>
            <div class="text">
                <button style="background: #61c436;">Food</button>
                <h1>Stunning Health Benefits of Eating Chocolates</h1>
                <span>4 day ago</span>
            </div>
        </div>
        <div>
            <div class="hover"></div>
            <div class="text">
                <button style="background:#e54e7e;">Fashion</button>
                <h1>Cool Car: Add Style And Class To Your Vehicle</h1>
                <span>4 day ago</span>
            </div>
        </div>
        <div>
            <div class="hover"></div>
            <div class="text">
                <button style="background: #f4b23f;">Lifestyle</button>
                <h1>What Will Natural Beauty Be Like In 100 Years?</h1>
                <span>4 day ago</span>
            </div>
        </div>

    </section>
</div>



<style type="text/css">
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
        width: 100% !important;
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

