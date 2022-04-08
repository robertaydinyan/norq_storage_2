<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Manufacturers'), 'Manufacturers');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if(\app\rbac\WarehouseRule::can('manufacturers', 'index')): ?>
<div class="manufacturer-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between mt-3 ">
        <h1  data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div  class="d-flex align-items-start pt-2">
            <?php if(\app\rbac\WarehouseRule::can('manufacturer', 'create')): ?>
                <?= Html::a(Yii::t('app', 'Create Manufacturer'), ['create'], ['class' => 'btn btn-primary mr-2']) ?>
            <?php endif; ?>
            <button onclick="tableToExcel('tbl','test','manufacturer.xls')" class="btn btn-primary  mr-2">Xls</button>
        </div>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('manufacturer', 'view') ? Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . \Yii::$app->language, [
                            'title' => Yii::t('app', 'View'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]) : '';
                    },
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('manufacturer', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('manufacturer', 'delete') ?
                            Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                                'title' => Yii::t('app', 'Delete'),
                                'class' => 'btn text-danger btn-sm',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                    'method' => 'post',
                                ],
                            ]) : '';
                    }
                ]],
        ],
    ]); ?>


</div>
<?php endif; ?>