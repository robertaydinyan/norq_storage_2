<?php

use app\modules\crm\models\ContactAdress;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use \app\modules\warehouse\models\Warehouse;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\WarehouseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Պահեստ';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= Url::to(['index']) ?>">Հետ</a></li>
        </ol>
    </nav>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?> <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-primary" >Ստեղծել Պահեստ</a></h4>

        <div style="padding:20px;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover'
            ],
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                [
                    'label' => 'Պահեստի տեսակը',
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
                [
                    'label' => 'Անուն',
                    'value' => function ($model) {
                        if($model->type != 4){
                            return $model->name;
                        } else {
                            return Warehouse::getContactAddressById($model->contact_address_id);
                        }

                    }
                ],
                [
                    'label' => 'Պահեստապետ',
                    'value' => function ($model) {
                        $user = $model->getUser($model->responsible_id);
                        return $user->name.' '.$user->last_name;
                    }
                ],
                [
                    'label' => 'Ապրանքներ',
                    'value' => function ($model) {
                        return '('.$model->productsCount.')';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Գործողություն'),
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::a('<i class="far fa-eye"></i>', $url, [
                                'title' => Yii::t('app', 'Դիտել'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]);
                        },
                        'update' => function ($url, $model) {
                            return
                                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                    'title' => Yii::t('app', 'Թարմացնել'),
                                    'class' => 'btn text-primary btn-sm mr-2'
                                ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Ջբջել'),
                                'class' => 'btn text-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    ]
                ],
            ],
        ]); ?>
        </div>
<button style="margin:20px;" onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary">Xls</button>
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