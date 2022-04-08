<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Currency */

$this->title = array(Yii::t('app', 'Currency') . ': ' . $model->symbol, 'Currency: ' . $model->symbol);
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="currency-view">

    <h1 data-title="Html::encode($this->title[1]" style="padding: 20px;"><?= Html::encode($this->title[0]) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-hover'],
        'attributes' => [
            'id',
            'symbol',
        ],
    ]) ?>

</div>
