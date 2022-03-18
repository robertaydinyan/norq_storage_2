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
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa fa-star-o ml-4"></i></span></h4>
    <div style="padding:20px;" class="table">
        <table class="table">
            <?php foreach ($communities as $community => $community_val){ ?>
                <tr>
                    <td><?php echo $community_val['id'];?></td>
                    <td><a class="nav-link" <?php echo \app\rbac\WarehouseRule::can('warehouse', 'show-by-type') ? 'href="' . Url::to(['show-by-type', 'lang' => \Yii::$app->language]) . '&type=' . $type . '&community=' . $community_val['id'] . '"' : ''?>><?php echo $community_val['name'];?> (<?php echo Warehouse::getCountByCommunity($type,$community_val['id']);?>)</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>