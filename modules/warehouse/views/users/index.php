<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = array(Yii::t('app', 'Users'),'Users');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);

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
    'name' => 'name',
    'last_name' => 'last name',
    'email' => 'email',
];

$actions = [
        'class' => 'yii\grid\ActionColumn',
        'header' => Yii::t('app', 'Action'),
        'template' => '{edit}{delete}{block}',
        'buttons' => [
            'edit' => function($url) {
                return ((\app\rbac\WarehouseRule::can('users', 'edit')) ?
                    ("<a href='" . URL::to($url) . "'><i class='fas fa-pencil-alt mr-3'></i></a>") : '');
            },
            'delete' => function($url, $model) {
                return ((\app\rbac\WarehouseRule::can('users', 'delete')) ?
                    ("<a onclick='return AreYouSure();' href='" . URL::to($url) . "'><i class=\"mr-3 fas " . (!$model->isDeleted ? 'fa-trash-alt text-danger' : ' fa-sync text-primary') . "\"></i></a>") : '');

            },
            'block' => function($url, $model) {
                return ((Yii::$app->user->identity->role == "admin") ?
                    ("<a class='change-site-status' 
                        onclick='href=\"javascript:void(0);\"'
                        data-user-id='" . $model->id . "'
                        data-status='" . (1 - $model->blocked) . "'
                    ><i class='fas " . ($model->blocked ? 'fa-ban' : 'fa-car') . "' style='color: red;'></i></a>") : '');
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
array_push($table_columns, $actions);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php if(\app\rbac\WarehouseRule::can('users', 'index')): ?>
<div class="user-index">
    <div class="d-flex flex-wrap justify-content-between ">
    <h1 class="" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <div class="d-flex align-items-start pt-2">
        <?php if(\app\rbac\WarehouseRule::can('users', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-primary mr-2"  ><?php echo Yii::t('app', 'Create user'); ?></a>
        <?php endif; ?>
        <button  onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary float-right mr-2">Xls</button>
        <button class="btn btn-primary mr-2 position-relative" style="float: right">
            <div id="list1" class="dropdown-check-list" tabindex="100">
                <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                <ul class="items">
                    <?php if ($columns):
                        foreach ($columns as $i => $k): ?>
                            <li><input type="checkbox"  class="hide-row" data-queue="<?php echo $i; ?>"  checked/><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                        <?php endforeach;
                    endif;?>
                </ul>
            </div>
        </button>
        <button class="btn btn-primary mr-2 filter" style="float: right" data-model="User"><i class="fa fa-wrench "></i></button>
        </div>

    </div>


    <div style="padding:20px;" class="table table-scroll">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover'
            ],
            'columns' => $table_columns,
        ]); ?>

    </div>
</div>

<?php endif; ?>

<script>
    function AreYouSure() {
        return window.confirm('Are you absolutely sure ? You will lose all the information about this user with this action.');
    }
</script>