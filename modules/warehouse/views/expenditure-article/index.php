<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'Expenditure Article'), 'Expenditure Article');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expenditure-article-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <div class="d-flex flex-wrap justify-content-between mt-3 mb-3">
        <h1  data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('currency', 'create')): ?>
                <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <button onclick="tableToExcel('tbl','test','ExpenditureArticles.xls')" class="btn btn-primary  mr-2">Xls</button>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            ['class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Action'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('currency', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
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
                ]],
        ],
    ]); ?>


</div>
