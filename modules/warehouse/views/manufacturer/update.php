<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Manufacturer */

$this->title = array(Yii::t('app', 'Update Manufacturer') . ': ' . $model->name, 'Update Manufacturer: ' . $model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Manufacturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="manufacturer-update">

    <h1 data-title="<?php echo $this->title[1]?>"><?= Html::encode($this->title[0]) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
