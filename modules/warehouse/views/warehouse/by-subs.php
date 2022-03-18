<?php

use app\modules\warehouse\models\Warehouse;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Warehouse');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><a href=""><i class="fa fa-star-o ml-4" style="font-size: 30px"></i></a></h4>
    <div style="padding:20px;" class="table">
        <table class="table">
            <?php foreach ($subs as $sub => $sub_val){ ?>
                <tr>
                    <td><?php echo $sub_val->id;?></td>
                    <td><a class="nav-link" href="<?= Url::to(['show-by-type', 'lang' => \Yii::$app->language]) ?>&group_id=<?php echo $sub_val->id;?>"><?php echo $sub_val->name;?> (<?php echo $sub_val->warehouseCount;?>)</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>