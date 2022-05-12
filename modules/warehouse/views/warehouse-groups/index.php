<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->title = array(Yii::t('app', 'Virtual (types)'),'Virtual (types)');
$this->params['breadcrumbs'][] = $this->title[0];


$table_all_columns = array(
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
    'name' => 'name',
);

$table_columns = [];

if (isset($columns)) {
    foreach ($columns as $column) {
        if ($table_all_columns[$column->row_name]) {
            array_push($table_columns, $table_all_columns[$column->row_name]);
        }
    }
}
if (count($table_columns) == 0) {
    $table_columns = $table_all_columns;
}
$actions = [
    'class' => 'yii\grid\ActionColumn',
    'template' => '{update}{delete}',
    'buttons' => [
        'update' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('warehouse-groups', 'update') ?
                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
        },
        'delete' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('warehouse-groups', 'delete') ? Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
                'title' => Yii::t('app', 'Delete'),
                'class' => 'btn text-danger btn-sm',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                    'method' => 'post',
                ],
            ]) : '';
        }

    ]
];

array_push($table_columns, $actions);

?>
?>
<?php if(\app\rbac\WarehouseRule::can('warehouse-groups', 'index')): ?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('warehouse-groups', 'create')): ?>
                <a  href="<?= Url::to(['create']) ?>"  class="btn  btn-primary" ><?php echo Yii::t('app', 'Create');?></a>
            <?php endif; ?>
                <button  onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary ">Xls</button>
            <button class="btn btn-primary mr-2 position-relative" >
                <div id="list1" class="dropdown-check-list" tabindex="100">
                    <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                    <ul class="items">
                        <?php if ($columns):
                            foreach ($columns as $i => $k): ?>
                                <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>"
                                           checked/><?php echo Yii::t('app', $k->row_name_normal) ?> </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                </div>
            </button>
            <button class="btn btn-primary mr-2 filter"  data-model="WarehouseGroups"><i
                        class="fa fa-wrench "></i></button>
        </div>
    </div>
    <div style="padding:20px;">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover '
            ],
            'columns' => $table_columns,
        ]) ?>

        <?php Pjax::end(); ?>
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