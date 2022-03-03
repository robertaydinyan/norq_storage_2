<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\NomenclatureProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ապրանքի Նոմենկլատուրա';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<div class="group-product-index">
    <?php echo $this->render('/menu_dirs', array(), true)?>
    <h4 style="padding: 20px;"><?= Html::encode($this->title) ?>  <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-primary" >Ստեղծել Ապրանքի Նոմենկլատուրա</a></h4>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div style="padding:20px;" >
        <div class="row">
            <div class="col-sm-3">
                <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                    <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                        <li class="file-tree-folder"> <span data-name="l<?= $tableTreeGroup['name'] ?>"> <?= $tableTreeGroup['name'] ?> </span>
                            <ul style="display: block;">
                                <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/nomenclature-product/tree_table_second.php', [
                                    'tableTreeGroup' => $tableTreeGroup,
                                ]); ?>
                            </ul>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-sm-9">
                 <?php if(isset($_GET['id'])){?>
                <br>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        'id',
                         [
                           'label' => 'Նկար',
                           'format'=>'html',
                           'value' => function ($model) {
                            if($model->img){
                               return '<a target="_blank" href="'.$model->img.'" ><img width="100" src="'.$model->img.'"></a>';
                            } else {
                                return '';
                            }
                           }
                         ],
                        'vendor_code',
                        'name',
                        //'groupProduct.name',
                        [
                            'attribute' => 'groupName',
                            'label' => 'Խումբ',
                            'value' => function ($model) {
                                return $model->groupProduct->name;
                            }
                        ],
                        'production_date',
                        //'type',
                        //'individual',
                        //'qty_type',
                        //'group_id',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => Yii::t('app', 'Գործողություն'),
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
                ]); ?>
                <?php } ?>
            </div>
        </div>
    </div>

</div>