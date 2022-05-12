<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isFavorite boolean */

$this->title = array(Yii::t('app', 'Currencies'), 'Currencies');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

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
    'symbol' => [
        'attribute' => 'symbol'
    ],
    'code' =>'code',
    'value' => [
        'label' => Yii::t('app', 'Value'),
        'value' => function($model) {
            return $model->getCurrencyValue($model->id);
        }
    ],
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
    'header' => Yii::t('app', 'Action'),
    'template' => '{view}{update}{delete}',
    'buttons' => [
        'view' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('currency', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url, [
                'title' => Yii::t('app', 'View'),
                'class' => 'btn text-primary btn-sm mr-2'
            ]) : '';
        },
        'update' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('currency', 'update') ?
                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                    'title' => Yii::t('app', 'Update'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
        },
        'delete' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('currency', 'delete') ?
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
];

array_push($table_columns, $actions);

?>

<?php if(\app\rbac\WarehouseRule::can('currency', 'index')): ?>
    <div class="currency-index">
        <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between mt-3 mb-3">
        <h1  data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('currency', 'create')): ?>
                <?= Html::a(Yii::t('app', 'Create Currency'), ['create'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <button onclick="tableToExcel('tbl','test','currency.xls')" class="btn btn-primary  mr-2">Xls</button>
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
            <button class="btn btn-primary mr-2 filter"  data-model="Currency"><i
                        class="fa fa-wrench "></i></button>
        </div>

    </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover '
            ],
            'columns' => $table_columns,
        ]) ?>



    </div>
<?php endif; ?>