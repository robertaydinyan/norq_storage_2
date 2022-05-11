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
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-primary" ><?php echo Yii::t('app', 'Create an analog'); ?></a>
        <?php endif; ?>
    </h1>
    <div style="padding: 20px;">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-hover'
        ],
        'columns' => [
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
            ],
           /* 'isDeleted' => [
                'label' =>  Yii::t('app', 'Status'),
                'format' => 'html',
                'value' => function ($model) {
                    $isDeleted = $model->isDeleted;
                    if ($isDeleted == 1){
                        return "<p class='text-center p-2 bg-danger w-50 text-white m-auto'>Deleted</p>";

                    }else {
                        return  "<p class='text-center p-2 bg-primary w-50 text-white m-auto'>Saved</p>";
                    }
                }
            ],*/

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Reference'),
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                       return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Update'),
                            'class' => 'btn text-primary btn-sm mr-2'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fas ' . (!$model->isDeleted ? 'fa-trash-alt' : 'fa-sync text-primary') . '"></i>', $url, [
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
