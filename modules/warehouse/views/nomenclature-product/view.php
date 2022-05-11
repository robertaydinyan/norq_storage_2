<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\warehouse\models\Product;
/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\NomenclatureProduct */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = array($model->name);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Product Nomenclature'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
\yii\web\YiiAsset::register($this);
?>
<div class="nomenclature-product-view group-product-index">

    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    <div class="row" style="padding:20px;">
       
        <div  class="col-3">
            
            <?= DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'tl'],
                 'template' => function($attribute, $index, $widget){
                    if($attribute['value'])
                    {
                        return "<tr><th>{$attribute['label']}</th><td>{$attribute['value']}</td></tr>";
                    }
                },
                'attributes' => [
                    [
                        'attribute' => 'vendor_code',
                        'label' => Yii::t('app', 'Vendor code'),
                        'value' => function($model) {
                            return $model->vendor_code;
                        }
                    ],
                    [
                        'attribute' => 'name',
                        'label' => Yii::t('app', 'Name'),
                        'value' => function($model) {
                            return $model->name;
                        }
                    ],
                    [
                        'attribute' => 'group_id',
                        'label' => Yii::t('app', 'Group'),
                        'value' => function ($model) {
                            return $model->getGroupProduct()->one()['name'];
                        }
                    ],
                    [
                        'attribute' => 'production_date',
                        'label' => Yii::t('app', 'Production date'),
                        'value' => function($model) {
                            return $model->production_date ?  date('d-m-Y', strtotime($model->production_date)) : null;
                        }
                    ],
                    [
                        'attribute' => 'expiration_date',
                        'label' => Yii::t('app', 'Expiration date'),
                        'value' => function($model) {
                            return $model->expiration_date ?  date('d-m-Y', strtotime($model->expiration_date)) : null;
                        }
                    ],
                    [
                        'label' => Yii::t('app', 'Days count'),
                        'value' => function($model) {
                            return ($model->production_date && $model->expiration_date) ?  (strtotime($model->expiration_date) - strtotime($model->production_date)) / (60 * 60 * 24) : null;
                        }
                    ],
                    'series',
                    'ref',
                    [
                        'attribute' => 'expenditure_article',
                        'label' => Yii::t('app', 'Expenditure Article'),
                        'value' => function($model) {
                            return $model->expArticle->name;
                        }
                    ],
                    [
                        'attribute' => 'qty_type',
                        'label' => Yii::t('app', 'Quantity type'),
                        'value' => function ($model) {
                            return $model->getQtyType()->one()['type'];
                        }
                    ],
                    [
                        'attribute' => 'is_vat',
                        'label' => Yii::t('app', 'Vat'),
                        'value' => function ($model) {
                            return $model->vatName->name;
                        }
                    ],
                    [
                        'attribute' => 'manufacturer',
                        'label' => Yii::t('app', 'Manufacturer'),
                        'value' => function($model) {
                            return $model->manufacturerName->name;
                        }
                    ],
                    'technical_description',
                    'comment',
                    'other',
                    [
                        'attribute' => 'individual',
                        'label' => Yii::t('app', 'Individual'),
                        'value' => function ($model) {
                            return Yii::t('app', $model->individual ? 'Yes' : 'No');
                        }
                    ],
                ],
            ]) ?>
        </div>
        <div class="col-9">
             <?php 
                  if($model->id) {
                    $products = Product::find()->select('*,SUM(count) as count ')->where(['nomenclature_product_id'=>$model->id])->groupBy(['warehouse_id'])->andWhere(['>','count','0'])->all();
                     echo $this->renderFile('@app/modules/warehouse/views/product/product-info.php', ['products' => $products]);
                  }
                ?>
        </div>
<!--        <div class="col-4">-->
<!--            <h5>--><?php //echo Yii::t('app', 'Barcodes');?><!--</h5>-->
<!--            --><?//= GridView::widget([
//                'dataProvider' => $dataProvider,
//                'tableOptions' => [
//                    'class' => 'table table-hover'
//                ],
//                'columns' => [
//                    'id',
//                    'code'
//                ],
//            ]); ?>
<!--        </div>-->
    </div>
    <p style="padding:20px;">
        <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
<style>
  .tl td,.tl th{
    padding: 10px;
   border-bottom:2px solid #0055a5 !important;
  }
</style>