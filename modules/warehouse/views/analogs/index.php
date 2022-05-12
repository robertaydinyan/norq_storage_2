<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = array(Yii::t('app', 'Analogs'),'Analogs');
$this->params['breadcrumbs'][] = $this->title[0];
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
   'product_id' =>  [
        'label' => 'Օրիգինալ',
        'value' => function ($model) {
            return $model->getNomiclatureName(true);
        }
    ],
   'analog_id' => [
        'label' => 'Անալոգ',
        'value' => function ($model) {
            return $model->getNomiclatureName(false);
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
    'header' => Yii::t('app', 'Reference'),
    'template' => '{update}{delete}',
    'buttons' => [
        'update' => function ($url, $model) {
            return \app\rbac\WarehouseRule::can('analogs', 'update') ?
                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                'title' => Yii::t('app', 'Update'),
                'class' => 'btn text-primary btn-sm mr-2'
            ]) : '';
        },
        'delete' => function ($url, $model) {
            return   \app\rbac\WarehouseRule::can('analogs', 'delete') ?
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
<?php if(\app\rbac\WarehouseRule::can('analogs', 'index')): ?>
<div class="group-product-index" style="padding-top: 20px;">
     <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between align-items-center">
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <?php if(\app\rbac\WarehouseRule::can('analogs', 'create')): ?>
        <div>
        <a style="margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create an analog'); ?></a>
            <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary  mr-2">Xls</button>
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
            <button class="btn btn-primary mr-2 filter"  data-model="Analogs"><i
                        class="fa fa-wrench "></i></button>
        <?php endif; ?>
        </div>
    </div>
    <div style="padding: 20px;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover '
            ],
            'columns' => $table_columns,
        ]) ?>

   </div>
</div>
<?php endif; ?>