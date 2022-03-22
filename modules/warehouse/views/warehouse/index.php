<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Warehouse type'),'Warehouse type');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title[0];
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<div class="group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;" class="show-modal"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
    <?php echo \app\rbac\WarehouseRule::can('warehouse', 'create') ? '<a style="float: right" href="' . Url::to(['create', 'lang' => \Yii::$app->language]) . '" class="btn btn-primary "  >' .  Yii::t("app", "Create Warehouse") . '</a>' : ''; ?>
    </h1>

    <div style="padding:20px;" class="table">
        <table class="kv-grid-table table table-hover  kv-table-wrap">
            <?php foreach ($warehouse_types as $ware_type => $ware_type_val){ ?>
            <tr>

                <td><a class="nav-link" <?php echo \app\rbac\WarehouseRule::can('warehouse', 'show-by-type') ? ('href="' . Url::to(['show-by-type', 'lang' => \Yii::$app->language]) . '&type=' . $ware_type_val->id) . '"' : '' ?>><?php echo $ware_type_val->{'name_' . $lang};?></a></td>
                <td><a class="nav-link" <?php echo \app\rbac\WarehouseRule::can('warehouse', 'show-by-type') ? 'href="' . Url::to(['show-by-type', 'lang' => \Yii::$app->language]) . '&type=' . $ware_type_val->id . '">' . \Yii::t('app','View') : '>';?> (<?php echo $ware_type_val->count;?>)</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>

</div>





