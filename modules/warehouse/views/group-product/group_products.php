<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\db\ActiveQuery;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\GroupProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tableTreeGroups yii\data\ActiveDataProvider */
/* @var $groupProducts yii\data\ActiveDataProvider */

$this->title = 'Ապրանքներ';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
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

<div  class="group-product-index">
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-success" >Ստեղծել Խումբ</a>
        <a href="/warehouse/product" style="float: right;margin-right: 10px;" class="btn btn-success">Պահեստներ</a>
    </h1>

    <div style="clear: both;"></div>
    <div class="row">
        <div class="col-lg-3" style="padding: 1px 5px 5px 40px;">
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                    <li class="file-tree-folder"> <span> <?= $tableTreeGroup['name'] ?></span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/group-product/tree_table.php', [
                                'tableTreeGroup' => $tableTreeGroup,
                                'groupProducts' => $groupProducts
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-lg-9">
            <br>
    <table id="products" class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap" style="width:95%;background: white;">
    <thead>
    <tr>
        <th>Անուն</th>
        <th>Գին</th>
        <th>Քանակ</th>
        <th>Մատակարար</th>
        <th>Մեկնաբանություն</th>
        <th>Ինդիվիդուալ</th>
        <th>Պահեստի Տեսակ</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($haveProducts['result'] as $kproducts => $products) : ?>
  
        <tr>
            <td><?= $products['n_product_name'] ?></td>
            <td><?= number_format($products['price'],0,'.',','); ?> Դր․</td>
            <td><?=$products['count'] ?></td>
            <td><?= $products['supplier_name'] ?></td>
            <td><?= $products['comment'] ?></td>
            <td><?= $products['mac_address'] ?></td>
            <td><?= $products['warehouse_type'] ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    
</table>
 <nav aria-label="Page navigation">
          <ul class="pagination">
            <?php 
                for($page = 1; $page<= $haveProducts['total']; $page++) {  
                       $active = '';
                       if($page< intval($_GET['page'])-7 && $page != 1){
                        continue;
                       }
                       if($page > intval($_GET['page'])+7 && $page != $haveProducts['total']){
                        continue;
                       }
                       if(isset($_GET['page']) && $page == intval($_GET['page'])){
                          $active = 'active';
                       }
                       if(!intval($_GET['group_id'])){ 
                         echo '<li class="page-item '.$active.'"><a class="page-link " href="/warehouse/group-product/show-group-products?page=' . $page . '">' . $page . '</a></li>';  
                       } else {
                         echo '<li class="page-item '.$active.'"><a class="page-link " href="/warehouse/group-product/show-group-products?page=' . $page . '&group_id='.intval($_GET['group_id']).'">' . $page . '</a></li>';  
                       }
                    }
               ?>
          </ul>
        </nav>
</div>
    </div>
</div>
