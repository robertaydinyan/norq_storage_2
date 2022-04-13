<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';

$this->title = array($model->{'name_' . $lang});
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Nomenclature'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="nomenclature-product-view group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div class="row">
        <div class="col-5">
            <img alt="Nomenclature image" src="<?php echo $model->img ?>" style="max-width: 100%; max-height: 750px">
        </div>

        <div style="padding:20px;" class="col-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'vendor_code_' . $lang,
                        'label' => Yii::t('app', 'Vendor code'),
                        'value' => function($model) use ($lang) {
                            return $model->{'vendor_code_' . $lang};
                        }
                    ],
                    [
                        'attribute' => 'name_' . $lang,
                        'label' => Yii::t('app', 'Name'),
                        'value' => function($model) use ($lang) {
                            return $model->{'name_' . $lang};
                        }
                    ],
                    [
                        'attribute' => 'group_id',
                        'label' => Yii::t('app', 'Group'),
                        'value' => function ($model) {
                            $lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
                            return $model->getGroupProduct()->one()['name_' . $lang];
                        }
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'label' => Yii::t('app', 'Manufacturer'),
                        'value' => function($model) {
                            return $model->manufacturerName->name;
                        }
                    ],
                    'production_date',
                    [
                        'attribute' => 'is_vip',
                        'label' => 'Vip',
                        'value' => function ($model) {
                            return Yii::t('app', $model->is_vip ? 'Yes' : 'No');
                        }
                    ],
                    [
                        'attribute' => 'individual',
                        'label' => Yii::t('app', 'Individual'),
                        'value' => function ($model) {
                            return Yii::t('app', $model->individual ? 'Yes' : 'No');
                        }
                    ],
                    'min_qty',
                    'qty_for_notice',
                    [
                        'attribute' => 'qty_type',
                        'label' => Yii::t('app', 'Quantity type'),
                        'value' => function ($model) use ($lang) {
                            return $model->getQtyType()->one()['type_' . $lang];
                        }
                    ],
                    'expenditure_article',
                    'is_vat',
                    'other',
                    [
                        'attribute' => 'individual',
                        'label' => Yii::t('app', 'Individual'),
                        'value' => function ($model) {
                            return $model->individual ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
                        }
                    ],
                ],
            ]) ?>
        </div>
    </div>
    <p style="padding:20px;">
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id, 'lang' => \Yii::$app->language], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'lang' => \Yii::$app->language], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
