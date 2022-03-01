<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->title = 'Վիրտուալ(տեսակներ)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;"><?= Html::encode($this->title) ?> <a style="float: right" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել տեսակ</a></h1>
    <div style="padding:20px;">
        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'tableOptions' => [
                'class' => 'table table-hover'
            ],
            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'name',
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{delete}',
                    'buttons' => [
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
        ]); ?>

        <?php Pjax::end(); ?>
    </div>

</div>
