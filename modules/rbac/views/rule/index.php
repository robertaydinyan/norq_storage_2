<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $searchModel app\modules\rbac\models\search\BizRuleSearch */

$this->title = Yii::t('app', 'Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index card card-body border-0 shadow rounded mt-3">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3><?php echo Html::encode($this->title); ?></h3>
        <?php echo Html::a(Yii::t('app', 'Create Rule'), ['create'], ['class' => 'btn btn-primary']); ?>
    </div>

    <?php Pjax::begin(['timeout' => 5000]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => Yii::t('app', 'Name'),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
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
    ]);
    ?>

    <?php Pjax::end(); ?>
</div>
