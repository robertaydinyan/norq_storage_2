<?php

use app\components\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Services'), 'Services');

$this->params['breadcrumbs'][] =  $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

$actions = [
    'class' => 'yii\grid\ActionColumn',
    'header' => Yii::t('app', 'Action'),
    'template' => '{view}{delete}',
    'buttons' => [

        'view' => function ($url, $model) {
        return \app\rbac\WarehouseRule::can('complectation', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url, [
        'title' => Yii::t('app', 'View'),
        'class' => 'btn text-primary btn-sm mr-2'
        ]) : '';
        },
    'delete' => function ($url, $model) {
        return \app\rbac\WarehouseRule::can('complectation', 'delete') ? Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
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
    'price' => 'price',
    'name' => 'name',
    'other_cost' => 'other_cost',
    'created_at' => 'created_at',
//    'barcodes' => [
//        'label' => Yii::t('app', 'Barcodes'),
//        'format'=>'html',
//        'value' => function ($model) {
//            return $this-barcodes;
//        }
//    ],
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
<?php if(\app\rbac\WarehouseRule::can('complectation', 'index')): ?>
<div class="group-product-index">
    <div class="d-flex flex-wrap justify-content-between ">
    <h1  data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></span></h1>
        <div class="d-flex align-items-start pt-2">
            <?php if(\app\rbac\WarehouseRule::can('complectation', 'create')): ?>
                <a style="margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-primary mr-2" ><?php echo Yii::t('app', 'Create'); ?></a>
            <?php endif; ?>
                <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary  mr-2">Xls</button>
                <button class="btn btn-primary mr-2 px-1 position-relative" >
                    <div id="list1" class="dropdown-check-list " tabindex="100"  >
                        <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                        <ul class="items">
                            <?php if ($columns):
                                foreach ($columns as $i => $k): ?>
                                    <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>"  checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                                <?php endforeach;
                            endif;?>
                        </ul>
                    </div>
                </button>
                <button class="btn btn-primary mr-2 filter "  data-model="Complectation"><i class="fa fa-wrench "></i></button></a>
        </div>
</div>

    <?php endif; ?>
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