<?php

/* @var $this yii\web\View */

use app\components\TimeHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use yii\web\View;

$this->title = 'Analytics';
$this->registerJsFile('@web/js/plugins/chart/chart.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/analytics.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

<div class="container-fluid">
    <div class="card card-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="line-chart" data-connections-url="<?= Url::toRoute('load-connections') ?>">

                    <div class="form-group">
                        <?= Select2::widget([
                            'name' => 'month',
                            'data' => TimeHelper::getMonthListFromDate(),
                            'hideSearch' => true,
                            'options' => [
                                'placeholder' => 'Ընտրել ամիս',
                                'class' => 'connection_month'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true
                            ]
                        ]);
                        ?>
                    </div>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
