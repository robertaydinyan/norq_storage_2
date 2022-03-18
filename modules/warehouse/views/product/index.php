<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
use app\modules\warehouse\models\Warehouse;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ProductSearch */
/* @var $model app\modules\warehouse\models\ProductSearch */
/* @var $physicalWarehouse app\modules\warehouse\models\ProductSearch */
/* @var $requestSearch app\modules\warehouse\models\ProductSearch */
/* @var $nProducts app\modules\warehouse\models\ProductSearch */
/* @var $users app\modules\warehouse\models\ProductSearch */
/* @var $address app\modules\warehouse\models\ProductSearch */
/* @var $regions app\modules\warehouse\models\ProductSearch */
/* @var $groups app\modules\warehouse\models\ProductSearch */
/* @var $rols app\modules\warehouse\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('app', 'goods');
$this->params['breadcrumbs'][] = $this->title;


$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/createProduct.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/locations.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);

?>


<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 95%;
    }
</style>

<div class="group-product-index">

    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?><span class="star" ><i class="fa fa-star-o ml-4"></i></span>
        <?php echo \app\rbac\WarehouseRule::can('group-product', 'show-group-products') ?
        '<a href="/warehouse/group-product/show-group-products?lang=' . Yii::$app->language . '?>" class="btn btn-primary" style="float: right;">' .
        Yii::t('app', 'Groups') . '</a>' : '';
        ?>
    </h1>

<div class="product-index " style="padding: 20px;">


        <table  class="kv-grid-table table table-hover  kv-table-wrap" style="width:100%">
            <thead>
            <?php if (!empty($dataProvider['result'])) : ?>
            <tr>
                <th><?php echo Yii::t('app', 'Warehouse name'); ?> </th>
                <th><?php echo Yii::t('app', 'Product name'); ?> </th>
                <th><?php echo Yii::t('app', 'Product Picture'); ?> </th>
                <th><?php echo Yii::t('app', 'Quantity'); ?> </th>
                <th><?php echo Yii::t('app', 'Individual'); ?> </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dataProvider['result'] as $key => $products) : ?>
                <tr>
                     <td><?php if($products['type'] != 4){ echo $products['wname'];} else {
                        echo Warehouse::getContactAddressById($products['contact_address_id']);
                     } ?></td>
                    <td><?= $products['nomeclature_name'] ?></td>
                    <td><a target="_blank" href="<?= $products['img'] ?>" ><img width="100" src="<?= $products['img'] ?>"></a></td>
                    <?php if ($products['individual'] == 'false') : ?>
                        <td><?= $products['count_n_product'] ?> <?= $products['qtype'] ?></td>
                    <?php else : ?>
                        <td><a href="#" data-toggle="modal" data-target="#viewInfo" onclick="showInfo(<?= $products['nid'] ?>,<?php echo $products['id'];?>)"><?= $products['count_n_product'] ?> <?= $products['qtype'] ?> </a></td>
                    <?php endif; ?>
                      <td><?php if($products['individual']=='true'){ echo Yii::t('app', 'Yes');} else { echo Yii::t('app', 'No');} ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <?php endif; ?>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php
                for($page = 1; $page<= $dataProvider['total']; $page++) {
                       $active = '';
                       if(isset($_GET['page']) && $page == intval($_GET['page'])){
                          $active = 'active';
                       }
                        echo '<li class="page-item '.$active.'"><a class="page-link " href="/warehouse/product?page=' . $page . '&lang=' . \Yii::$app->language . '">' . $page . '</a></li>';
                    }
               ?>
          </ul>
        </nav>
    </div>
</div>

<div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="mod-content"></div>
                </div>
            </div>

        </div>
    </div>
<script>
    function showInfo(id,wid){
    if(id){
        $.ajax({
            url: '/warehouse/warehouse/get-product-info',
            method: 'get',
            dataType: 'html',
            data: { id: id,wid:wid},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}
</script>