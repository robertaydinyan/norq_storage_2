<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $groupProducts app\modules\warehouse\models\NomenclatureProduct */
/* @var $qtyTypes app\modules\warehouse\models\NomenclatureProduct */
/* @var $tableTreeGroups app\modules\warehouse\models\NomenclatureProduct */
/* @var $manufacturers app\modules\warehouse\models\Manufacturer */
/* @var $barcodes app\modules\warehouse\models\Barcode[] */

$this->title = array(Yii::t('app', 'Update') .  ': ' . $model->name,'Update');
$this->params['breadcrumbs'][] = ['label' => 'Nomenclature Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="nomenclature-product-update group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding:20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts,
        'tableTreeGroups'=> $tableTreeGroups,
        'qtyTypes' => $qtyTypes,
        'manufacturers' => $manufacturers,
        'type' => 'update',
        'barcodes' => $barcodes,
        'vats' => $vats
    ]) ?>
    </div>
</div>
