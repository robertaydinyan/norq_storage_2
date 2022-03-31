<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use app\modules\warehouse\models\SuppliersList;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\QtyTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Payments'),'Payments');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$table_all_columns = [
    'id' => 'id',
    'Supplier' => [
        'label' => Yii::t('app', 'Supplier'),
        'value' => function ($model) {
            $provider = SuppliersList::findOne($model->provider_id);
            return $provider->{'name_' . (explode('-', \Yii::$app->language)[0] ?: 'en')};
        }
    ],
    'amount' => 'price',
];
$actions = [
    'class' => 'yii\grid\ActionColumn',
    'header' => Yii::t('app', 'Reference'),
    'template' => '{update}{delete}',
    'buttons' => [
        'update' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('payments-log', 'update') ?
                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
        },
        'delete' => function ($url, $model) {
            return  \app\rbac\WarehouseRule::can('payments-log', 'delete') ?
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

$table_columns = [];
if (isset($columns)) {
    foreach ($columns as $column) {
        if ($table_all_columns[$column->row_name]) {
            array_push($table_columns, $table_all_columns[$column->row_name]);
        }
    }
}

if (count($table_columns) == 0){
    $table_columns = $table_all_columns;
}
array_push($table_columns, $actions);
?>
<?php if(\app\rbac\WarehouseRule::can('payments-log', 'index')): ?>
<div class="group-product-index">
    <div class="">
       <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/warehouse/payments"><?php echo Yii::t('app', 'Statistics'); ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/payments-log"><?php echo Yii::t('app', 'Payments'); ?></a></li>
            </ul>
        </div>
    </nav>
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
        <?php if(\app\rbac\WarehouseRule::can('payments-log', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn  btn-primary" ><?php echo Yii::t('app', 'make a payment'); ?></a>
        <?php endif; ?>
        <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary float-right mr-2">Xls</button>
        <button class="btn btn-primary mr-2" style="float: right">
            <div id="list1" class="dropdown-check-list" tabindex="100" style="width: -webkit-fill-available;">
                <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                <ul class="items">
                    <?php if ($columns):
                        foreach ($columns as $k): ?>
                            <li><input type="checkbox" /><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                        <?php endforeach;
                    endif;?>
                </ul>
            </div>
        </button>
        <button class="btn btn-primary mr-2 filter" style="float: right" data-model="ProviderPayments"><i class="fa fa-wrench "></i></button></a></h1>
    </h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="padding: 20px;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => $table_columns,
    ]);

    ?>


    </div>
</div>
    <?php endif; ?>



