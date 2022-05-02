<?php

use app\modules\crm\models\ContactAdress;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \app\modules\warehouse\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $columns app\modules\warehouse\models\TableRowsStatus[] */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Warehouse type'),'Warehouse type');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title[0];

$table_all_columns = [
    'id' => 'id',
    'type' => [
        'label' => Yii::t('app', 'Warehouse type'),
        'format'=>'html',
        'value' => function ($model) {
            switch ($model->type){
                case 1:
                    $icon = '<i  class="fa fa-warehouse"></i>';
                    break;
                case 3:
                    $icon = '<i  class="fa fa-server"></i>';
                    break;
                case 4:
                    $icon = '<i  class="fa fa-home"></i>';
                    break;
                case 2:
                    $icon = '<i  class="fa fa-broadcast-tower"></i>';
                    break;
                default:
                    $icon = '<i  class="fa fa-warehouse"></i>';
                    break;
            }
            return $icon.'  '.$model->getType($model->type)->name;
        }
    ],
    'name' => 'name',
    'responsible_id' => [
        'label' => Yii::t('app', 'storekeeper'),
        'value' => function ($model) {
            $user = $model->getUser($model->responsible_id);
            return $user->name.' '.$user->last_name;
        }
    ],
    'products' => [
        'label' => Yii::t('app', 'goods'),
        'value' => function ($model) {
            return '('.$model->productsCount.')';
        }
    ]
];


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
    'header' => Yii::t('app', 'Action'),
    'template' => '{view}{update}{delete}',
    'buttons' => [
        'view' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('warehouse', 'view') ?
                Html::a('<i class="fas fa-eye"></i>', $url, [
                    'title' => Yii::t('app', 'View'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
        },
        'update' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('warehouse', 'update') ?
                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
        },
        'delete' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('warehouse', 'delete') ?
                Html::a('<i class="fas fa-trash-alt"></i>', $url, [
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
<div class="group-product-index">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= Url::to(['index', 'lang' => Yii::$app->language]) ?>"><?php echo Yii::t('app', 'Back'); ?></a></li>
        </ol>
    </nav>
    <div class="d-flex flex-wrap justify-content-between">
    <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>

      <div class="d-flex align-items-start pt-2">
          <?php echo  (\app\rbac\WarehouseRule::can('warehouse', 'create') ?
              ('<a  href="' . Url::to(['create', 'lang' => Yii::$app->language]) . '"  class="btn btn-primary mr-2" >' .
                  Yii::t('app', 'Create Warehouse') . '</a>') : ''); ?>
          <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary mr-2">Xls</button>
            <button class="btn btn-primary mr-2 position-relative" >
                <div id="list1" class="dropdown-check-list" tabindex="100" >
                    <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                    <ul class="items">
                        <?php if ($columns):
                            foreach ($columns as $i => $k): ?>
                                <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>" checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                            <?php endforeach;
                        endif;?>
                    </ul>
                </div>
            </button>
            <button class="btn btn-primary mr-2 filter"  data-model="Warehouse"><i class="fa fa-wrench "></i></button></a>
      </div>
    </div>
    <div style="padding:20px;" class="table-scroll">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover'
            ],
            'columns' => $table_columns,
        ]); ?>
        </div>


<script>
    window.onload = function(){
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
    })();  
</script>