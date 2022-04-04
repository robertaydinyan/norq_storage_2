<?php

use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductForRequest;
use app\modules\warehouse\models\ShippingProducts;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';

$this->title = array($model->shippingtype->{'name_' . $lang} . ' view '.$model->id, $model->shippingtype->name_en . ' view '.$model->id);
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<div class="shipping-request-view group-product-index">

    

    <div style="padding:20px;"  id="print">
        <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <br>
        <div class="row">
            <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-5 table-scroll5">
                <table class="table table-hover">
                    <?php if($model->provider->{'name_' . $lang}){ ?>
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Delivery warehouse'); ?></th>
                        <td><?php echo $model->provider->{'name_' . $lang};?></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->supplier->{'name_' . $lang}){ ?>
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Supplier warehouse'); ?></th>
                        <td><?php echo $model->supplier->{'name_' . $lang};?></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->request_id){ ?>
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Purchase request'); ?></th>
                        <td><a href="/warehouse/shipping-request/view?id=<?php echo $model->request_id;?>"><?php echo Yii::t('app', 'Purchase request'); ?> (<?php echo $model->request_id;?>)</a></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->supplierp->{'name_' . $lang} && $model->shipping_type != 9){ ?>
                        <tr>
                            <th scope="col"><?php echo Yii::t('app', 'Supplier'); ?></th>
                            <td><?php echo $model->supplierp->{'name_' . $lang};?></td>
                        </tr>
                    <?php } ?>
                    <?php if($model->supplierp->{'name_' . $lang} && $model->shipping_type == 9){ ?>
                        <tr>
                            <th scope="col"><?php echo Yii::t('app', 'Partner'); ?></th>
                            <td><?php echo $model->supplierp->{'name_' . $lang};?> <?php echo @$model->supplierp->surname;?></td>
                        </tr>
                    <?php } ?>
                    <?php if($model->partner->{'name_' . $lang}){ ?>
                        <tr>
                            <th scope="col"><?php echo Yii::t('app', 'Partner'); ?></th>
                            <td><?php echo $model->partner->name;?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Status'); ?></th>
                        <td><?php echo $model->status_->{'name_' . $lang};?></td>
                    </tr>
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Created'); ?></th>
                        <td><?php echo date('d.m.Y',strtotime($model->created_at));?></td>
                    </tr>
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Responsible'); ?></th>
                        <td><?php echo $model->user->name.' '.$model->user->last_name;?></td>
                    </tr>

                    <?php if($model->invoice){ ?>
                        <tr>
                            <th scope="col"><?php echo Yii::t('app', 'invoices'); ?></th>
                            <td><?php echo $model->invoice;?></td>
                        </tr>
                    <?php } ?>
                
                        <tr>
                            <th scope="col"><?php echo Yii::t('app', 'Comment'); ?></th>
                            <td><?php echo $model->comment;?></td>
                        </tr>
          
                    <tr>
                        <th scope="col"><?php echo Yii::t('app', 'Total amount'); ?></th>
                        <td><?php echo number_format($model->totalsum,0,',','.');?>  <?php echo Yii::t('app', 'dram'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-7 table-scroll">
                <?php
                  if($model->shippingtype->id != 5){
                     $products = ShippingProducts::findByShip($model->id);
                  } else {
                     $products = ShippingProducts::findByShipReq($model->id);
                  }
                ?>
                       <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th><?php echo Yii::t('app', 'good'); ?></th>
                        <th><?php echo Yii::t('app', 'Product Picture'); ?></th>
                        <th><?php echo Yii::t('app', 'Quantity'); ?></th>
                        <?php if($model->shipping_type == 9){ ?>
                            <th><?php echo Yii::t('app', 'Cost'); ?></th>
                        <?php } ?>
                        <th><?php echo Yii::t('app', 'Price'); ?></th>
                        <th><?php echo Yii::t('app', 'Comment'); ?></th>
                        <th><?php echo Yii::t('app', 'Series'); ?></th>
                    </tr>
                    </thead>
                    <?php if(!empty($products)){?>
                        <tbody>

                        <?php foreach ($products as $product => $prod_val){?>
                            <tr>

                                <td><?php echo $prod_val['id'];?></td>
                                <td><?php echo $prod_val['name'];?></td>
                                <td><a target="_blank" href="<?= $prod_val['img'] ?>" ><img width="100" src="<?= $prod_val['img'] ?>"></a></td>
                                <td><?php echo $prod_val['count'];?> <?php echo $prod_val['qty_type'];?></td>
                                <?php if($model->shipping_type == 9){ ?>
                                <td> <?php echo Product::findOne($prod_val['product_id'])->price;?> <?php echo Yii::t('app', 'dram'); ?></td>
                                <?php } ?>
                                <th><?php echo $prod_val['price'];?> <?php echo Yii::t('app', 'dram'); ?></th>
                                <th><?php echo Product::findOne($prod_val['product_id'])->comment;?></th>
                                <td <?php if($prod_val['individual'] == 'true'){ echo 'onclick="showLog(\''.$prod_val['mac'].'\')"';}?>><?php if($prod_val['individual'] == 'true'){ echo '<a href="#">'.$prod_val['mac'].'</a>';} ?></td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    <?php } ?>
                </table>



            </div>
        </div>
       
    </div>
     <button class="btn btn-primary" onclick="PrintElem('print');" style="margin:20px;"><?php echo Yii::t('app', 'Print'); ?></button>
</div>
<script>
    function PrintElem(el)
{
   var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}
</script>