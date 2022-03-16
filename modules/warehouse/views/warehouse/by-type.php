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
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?></h1>
    <div style="padding:20px;" class="table">
        <table class="kv-grid-table table table-hover  kv-table-wrap">
            <?php foreach ($regions as $region => $region_val){ ?>
                <tr>
                    <td><a class="nav-link" href="<?= Url::to(['by-type', 'lang' => \Yii::$app->language]) ?>&type=<?php echo $type;?>&region=<?php echo $region_val->id;?>"><?php echo $region_val->name;?></a></td>
                    <td><a class="nav-link" <?php echo \app\rbac\WarehouseRule::can('warehouse', 'show-by-type') ? 'href="' . Url::to(['show-by-type', 'lang' => \Yii::$app->language]) . '&type=' . $type . '&region=' . $region_val->id . '">' . Yii::t('app', 'View') : '>'; ?> (<?php echo Warehouse::getCountByRegion($type,$region_val->id);?>)</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>