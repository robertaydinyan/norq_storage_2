<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = array(Yii::t('app', 'Analogs'),'Analogs');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index" style="padding-top: 20px;">
     <?php echo $this->render('/menu_dirs', array(), true)?>
    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
        <?php if(\app\rbac\WarehouseRule::can('qty-type', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create' ,'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create an analog'); ?></a>
        <?php endif; ?>
    </h1>
    <div style="padding: 20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
            'id',
            [
                'label' => 'Օրիգինալ',
                'value' => function ($model) {
                    return $model->getNomiclatureName(true);
                }
            ],
            [
                'label' => 'Անալոգ',
                'value' => function ($model) {
                    return $model->getNomiclatureName(false);
                }
            ],[
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Reference'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                       return Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . \Yii::$app->language , [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                           return Html::a('<i class="fas fa-trash-alt"></i>', $url . '&lang=' . \Yii::$app->language, [
                            'title' => Yii::t('app', 'Delete'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you absolutely sure ? You will lose all the information about this user with this action.'),
                                'method' => 'post',
                            ],
                        ]);
                    }

                ]
            ],
        ],
    ]); ?>

   </div>
</div>
