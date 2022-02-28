<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Translations');
$this->params['breadcrumbs'][] = $this->title;

?>
<!-- begin: .tray-center -->
<div class="table-layout">
    <div class="tray tray-center pr20">
        <div class="panel">
            <div class="panel-body pn">
                <div class="row pn mn mb10">
                    <div class="btn-group">
                        <button type="button" class="dropdown-toggle btn btn-default btn-sm ph15"
                                data-toggle="dropdown" title="" aria-expanded="false">
                            <?= Yii::t('app', 'show {n} entries', [
                                'n' => Yii::$app->request->get('per-page', 10)
                            ]) ?>
                            <b class="caret"></b>
                        </button>
                        <ul class="multiselect-container dropdown-menu pull-left">
                            <li>
                                <a href="<?= Url::to(['/message/index', 'per-page' => 10]) ?>">
                                    <?= Yii::t('app', 'show {n} entries', ['n' => 10]) ?>
                                </a>
                            </li>
                            <li class="">
                                <a href="<?= Url::to(['/message/index', 'per-page' => 25]) ?>">
                                    <?= Yii::t('app', 'show {n} entries', ['n' => 25]) ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/message/index', 'per-page' => 50]) ?>">
                                    <?= Yii::t('app', 'show {n} entries', ['n' => 50]) ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/message/index', 'per-page' => 100]) ?>">
                                    <?= Yii::t('app', 'show {n} entries', ['n' => 100]) ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="table-responsive">
                    <?php Pjax::begin(['id' => 'messagePjaxtbl']); ?>

                    <?php
                    try {
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'tableOptions' => [
                                'class' => 'table admin-form theme-warning tc-checkbox-1 fs13',
                                'id' => 'tbl_message'
                            ],
                            'summary' => false,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],

                                [
                                    'attribute' => 'message',
                                    'value' => 'id0.message',
                                ],
                                'language',
                                'translation:ntext',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]);
                    } catch (\Exception $exception) {
                        throw $exception;
                    }
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end: .tray-center -->
</div>