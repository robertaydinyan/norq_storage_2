<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchSuppliersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Վճարումներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
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
   <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <div id="w3-collapse" class="collapse navbar-collapse">
        <ul id="w5" class="navbar-nav w-100 nav">
            <li class="nav-item"><a class="nav-link" href="/warehouse/payments">ՎիՃակագրություն</a></li>
            <li class="nav-item"><a class="nav-link" href="/warehouse/payments-log">Վճարումներ</a></li>
        </ul>
    </div>
</nav>
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
    <div style="padding:20px;">
        <div>
            <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                <?php if($tableTreePartner['id'] != 7){
                    continue;
                } ?>
                    <ul style="display: block;" class="file-tree">
                        <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/payments/tree_table.php', [
                            'tableTreePartner' => $tableTreePartner,
                        ]); ?>
                    </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<br>
<style>
    .file-tree .file-tree-folder::after{
        content: '' !important;
    }
    .file-tree-folder li{
        border-bottom: 2px solid lightgray;
    }
</style>
<script>
    function showInvoices(id){
    if(id){
        $('.hide-block').hide();
        $.ajax({
            url: '/warehouse/suppliers-list/get-info-pay',
            method: 'get',
            dataType: 'html',
            data: { id: id},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}
</script>