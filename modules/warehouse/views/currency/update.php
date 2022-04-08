<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Currency */

$this->title = array(Yii::t('app', 'Update Currency') . ': ' . $model->symbol, 'Update Currency: ' . $model->symbol);
$this->params['breadcrumbs'][] = ['label' => 'Currencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="currency-update">

    <h1 data-title="<?php echo $this->title[1]?>"><?= Html::encode($this->title[0]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
