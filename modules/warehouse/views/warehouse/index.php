<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Պահեստ';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style>
    .modal-content-custom{
        display: none;
        width: 90%;
        height: 100%;
        position: fixed;
        top: 0px;
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
    .modal-content-custom .close {
        position: absolute;
        top: 10%;
        left: -60px;
        min-width: 60px;
        border-radius: 20px 0px 0px 20px;
        color: white;
        background: #2fc6f6;
        opacity:1!important;
        cursor: pointer;
        padding: 5px 5px 5px 15px;
    }
</style>
<div class="group-product-index">

    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?> <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-primary "  >Ստեղծել Պահեստ</a></h1>
    <div class="modal-content-custom">
        <div class="close"><i class="fa fa-close"></i></div>
    </div>
    <div  id="page-modal" style="display: none;">
        <div class="page1">
        </div>
    </div>
    <div style="padding:20px;" class="table">
        <table class="kv-grid-table table table-hover  kv-table-wrap">
            <?php foreach ($warehouse_types as $ware_type => $ware_type_val){ ?>
            <tr>
              
                <td><a class="nav-link" href="<?= Url::to(['by-type']) ?>?type=<?php echo $ware_type_val->id;?>"><?php echo $ware_type_val->name;?></a></td>
                <td><a class="nav-link" href="<?= Url::to(['show-by-type']) ?>?type=<?php echo $ware_type_val->id;?>">Դիտել (<?php echo $ware_type_val->count;?>)</a></td>
            </tr>
            <?php } ?>
        </table>
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
