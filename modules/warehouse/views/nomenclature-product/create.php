<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $groupProducts app\modules\warehouse\models\NomenclatureProduct */
/* @var $qtyTypes app\modules\warehouse\models\NomenclatureProduct */
/* @var $tableTreeGroups app\modules\warehouse\models\NomenclatureProduct */

$this->title = array(Yii::t('app', 'Create product nomenclature'),'Create product nomenclature');
$this->params['breadcrumbs'][] = ['label' => 'Nomenclature Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
?>
<div class="group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div style="padding: 20px;">
    <?= $this->render('_form', [
        'model' => $model,
        'groupProducts' => $groupProducts,
        'qtyTypes' => $qtyTypes,
        'tableTreeGroups'=> $tableTreeGroups,
        'type' => 'create'
    ]) ?>
    </div>
</div>
