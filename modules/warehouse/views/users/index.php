<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = array(Yii::t('app', 'Users'),'Users');
$this->params['breadcrumbs'][] = $this->title[0];
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="user-index">

    <h1 style="padding: 20px;" class="show-modal" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
        <?php if(\app\rbac\WarehouseRule::can('users', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary "  ><?php echo Yii::t('app', 'Create user'); ?></a>
        <?php endif; ?>
        <button class="btn btn-primary mr-2" style="float: right">
            <div id="list1" class="dropdown-check-list" tabindex="100" >
                <span class="anchor"><i class="fa fa-list"></i></span>
                <ul class="items">
                    <?php if ($columns):
                        foreach ($columns as $k): ?>
                            <li><input type="checkbox" /><?php echo Yii::t('app',$k->row_name_normal) ?> </li>
                        <?php endforeach;
                    endif;?>
                </ul>
            </div>
        </button>
        <button class="btn btn-primary mr-2 filter" style="float: right" data-model="User"><i class="fa fa-wrench "></i></button></a></h1>
    </h1>

 <!-- <div style="padding:20px;" class="table">
        <table class="kv-grid-table table table-hover  kv-table-wrap">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>last name</th>
                <th>email</th>
                <th>actions</th>
            </tr>
            <?php /*if (isset($users)):
                foreach ($users as $user): */?>
                <tr>
                    <td><?php /*echo $user->id; */?></td>
                    <td><?php /*echo $user->name; */?></td>
                    <td><?php /*echo $user->last_name; */?></td>
                    <td><?php /*echo $user->email; */?></td>
                    <td>
                        <?php /*if(\app\rbac\WarehouseRule::can('users', 'edit')): */?>
                            <a href="<?php /*echo URL::to(['users/edit', 'lang' => Yii::$app->language, 'id' => $user->id]); */?>"><i class="fas fa-pencil-alt mr-3"></i></a>
                        <?php /*endif; */?>
                        <?php /*if(\app\rbac\WarehouseRule::can('users', 'delete')): */?>
                            <a onclick="return AreYouSure();" href="<?php /*echo URL::to(['users/delete', 'lang' => Yii::$app->language, 'id' => $user->id]); */?>"><i class="fas fa-trash-alt" style="color: red;"></i></a>
                        <?php /*endif; */?>
                    </td>
                </tr>
                <?php /*endforeach;
            endif; */?>
        </table>
    </div>-->

    <?php
    $actions = [
        'class' => 'yii\grid\ActionColumn',
        'header' => Yii::t('app', 'Action'),
        'template' => '{edit}{delete}',
        'buttons' => [

            'edit' => function ($url, $model) {
                return \app\rbac\WarehouseRule::can('users', 'edit') ? Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                    'title' => Yii::t('app', 'edit'),
                    'class' => 'btn text-primary btn-sm mr-2'
                ]) : '';
            },
            'delete' => function ($url, $model) {
                return \app\rbac\WarehouseRule::can('users', 'delete') ? Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
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
        'name' => 'name',
        'last_name' => 'last_name',
        'email' => 'email',

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

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => $table_columns,
    ]); ?>
</div>

<script>
    function AreYouSure() {
        return window.confirm('Are you absolutely sure ? You will lose all the information about this user with this action.');
    }
</script>