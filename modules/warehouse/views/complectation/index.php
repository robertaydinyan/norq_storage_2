<?php

use app\components\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Composition'), 'Composition');

$this->params['breadcrumbs'][] =  $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

    $actions = [
        'class' => 'yii\grid\ActionColumn',
        'header' => Yii::t('app', 'Action'),
        'template' => '{view}{delete}',
        'buttons' => [

            'view' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('complectation', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . \Yii::$app->language, [
            'title' => Yii::t('app', 'View'),
            'class' => 'btn text-primary btn-sm mr-2'
            ]) : '';
            },
        'delete' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('complectation', 'delete') ? Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
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

$table_all_columns = [
    'id' => 'id',
    'price' => 'price',
    'name' => 'name',
    'count' => 'count',
    'created_at' => 'created_at',
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

<div class="group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></span>
    <?php if(\app\rbac\WarehouseRule::can('complectation', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Composition'); ?></a>
    <?php endif; ?>
        <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary float-right mr-2">Xls</button>
        <button class="btn btn-primary mr-2 px-1" style="float: right">
            <div id="list1" class="dropdown-check-list " tabindex="100"  style="width: -webkit-fill-available;">
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
        <button class="btn btn-primary mr-2 filter" style="float: right" data-model="Complectation"><i class="fa fa-wrench "></i></button></a>
    </h1>



    <?php Pjax::begin(); ?>
    <div style="padding:20px;" class="table-scroll">


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => $table_columns,
    ]); ?>
    </div>
    <?php Pjax::end(); ?>

</div>

</div>

