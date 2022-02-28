<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

use app\modules\warehouse\models\SuppliersList;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\QtyTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Վճարումներ';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="group-product-index">
    <div class="group-product-index">
       <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/warehouse/payments">ՎիՃակագրություն</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/payments-log">Վճարումներ</a></li>
            </ul>
        </div>
    </nav>
    <h4 style="padding: 20px;" ><?= Html::encode($this->title) ?> <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn btn-sm btn-success" >Ստեղծել վճարում</a></h4>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div style="padding: 20px;">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'label' => 'Մատակարար',
                'value' => function ($model) {
                    $provider = SuppliersList::findOne($model->provider_id);
                    return $provider->name;
                }
            ],
            'price',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Հղում'),
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

    </div>
</div>
