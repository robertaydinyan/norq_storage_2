<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\QtyTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Unit of measurement'),'Unit of measurement');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('qty-type', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div>
        <?php if(\app\rbac\WarehouseRule::can('qty-type', 'create')): ?>
        <a style="margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create a unit of measurement'); ?></a>
        <?php endif; ?>
        <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary  mr-2">Xls</button>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="padding: 20px;" class="table-scroll">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id' => [
                'label' =>  Yii::t('app', 'ID'),
                'format' => 'html',
                'value' => function ($model) {
                    $isDeleted = $model->isDeleted;
                    if ($isDeleted == 1){
                        return $model->id . "<i class=\"fa fa-remove pl-3 text-danger\"></i>";

                    }else {
                        return  $model->id ;
                    }
                }
            ],
            [
                'header' => Yii::t('app', 'Unit of measurement'),
                'attribute' => 'type'
            ],
            /*'isDeleted' => [
                'label' =>  Yii::t('app', 'Status'),
                'format' => 'html',
                'value' => function ($model) {
                    $isDeleted = $model->isDeleted;
                    if ($isDeleted == 1){
                        return "<p class='text-center p-2 bg-danger w-50 text-white m-auto'>Deleted</p>";

                    }else {
                        return  "<p class='text-center p-2 bg-primary w-50 text-white m-auto'>Saved</p>";
                    }
                }
            ],*/

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Reference'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('qty-type', 'delete') ?
                        Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                'method' => 'post',
                            ],
                        ]) : '';
                    }

                ]
            ],
        ],
    ]); ?>

    </div>
</div>
<?php endif; ?>




<script>window.onload = function(){
        $('table').attr('id','tbl');
    }
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,'
            , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
            , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
            , format = function(s, c) {
            return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })
        }
            , downloadURI = function(uri, name) {
            var link = document.createElement("a");
            link.download = name;
            link.href = uri;
            link.click();
        }

        return function(table, name, fileName) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
            var resuri = uri + base64(format(template, ctx))
            downloadURI(resuri, fileName);
        }
    })();</script>