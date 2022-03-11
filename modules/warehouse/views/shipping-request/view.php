<?php

use app\modules\warehouse\models\Product;
use app\modules\warehouse\models\ProductForRequest;
use app\modules\warehouse\models\ShippingProducts;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shipping Requests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<div class="shipping-request-view group-product-index">

    

    <div style="padding:20px;"  id="print">
        <h4><?php echo $model->shippingtype->{'name_' . $lang};?> (<?= Html::encode($this->title) ?>)</h4>
        <br>
        <div class="row">
            <div class="col-sm-5">
                <table class="table table-hover">
                    <?php if($model->provider->name){ ?>
                    <tr>
                        <th scope="col">Հանձնող պահեստ</th>
                        <td><?php echo $model->provider->name;?></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->supplier->name){ ?>
                    <tr>
                        <th scope="col">Ստացող պահեստ</th>
                        <td><?php echo $model->supplier->name;?></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->request_id){ ?>
                    <tr>
                        <th scope="col">Գնման հայտ</th>
                        <td><a href="/warehouse/shipping-request/view?id=<?php echo $model->request_id;?>">Գնման հայտ (<?php echo $model->request_id;?>)</a></td>
                    </tr>
                    <?php } ?>
                    <?php if($model->supplierp->name && $model->shipping_type != 9){ ?>
                        <tr>
                            <th scope="col">Մատակարար</th>
                            <td><?php echo $model->supplierp->name;?></td>
                        </tr>
                    <?php } ?>
                    <?php if($model->supplierp->name && $model->shipping_type == 9){ ?>
                        <tr>
                            <th scope="col">Գործընկեր</th>
                            <td><?php echo $model->supplierp->name;?> <?php echo @$model->supplierp->surname;?></td>
                        </tr>
                    <?php } ?>
                    <?php if($model->partner->name){ ?>
                        <tr>
                            <th scope="col">Գործընկեր</th>
                            <td><?php echo $model->partner->name;?></td>
                        </tr>
                    <?php } ?>

                    <tr>
                        <th scope="col">Կարգավիճակ</th>
                        <td><?php echo $model->status_->{'name_' . $lang};?></td>
                    </tr>
                    <tr>
                        <th scope="col">Ստեղծվել է</th>
                        <td><?php echo date('d.m.Y',strtotime($model->created_at));?></td>
                    </tr>
                    <tr>
                        <th scope="col">Պատասխանատու</th>
                        <td><?php echo $model->user->name.' '.$model->user->last_name;?></td>
                    </tr>

                    <?php if($model->invoice){ ?>
                        <tr>
                            <th scope="col">Invoice</th>
                            <td><?php echo $model->invoice;?></td>
                        </tr>
                    <?php } ?>
                
                        <tr>
                            <th scope="col">Մեկնաբանություն</th>
                            <td><?php echo $model->comment;?></td>
                        </tr>
          
                    <tr>
                        <th scope="col">Ընդանուր գումար</th>
                        <td><?php echo number_format($model->totalsum,0,',','.');?> դր․</td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
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
                        <th>Ապրանք</th>
                        <th>Ապրանքի Նկար</th>
                        <th>Քանակ</th>
                        <?php if($model->shipping_type == 9){ ?>
                            <th>Ինքնարժեք</th>
                        <?php } ?>
                        <th>Գին</th>
                        <th>Մեկնաբանություն</th>
                        <th>Սերիա</th>
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
                                <td> <?php echo Product::findOne($prod_val['product_id'])->price;?> դր</td>
                                <?php } ?>
                                <th><?php echo $prod_val['price'];?> դր</th>
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
     <button class="btn btn-primary" onclick="PrintElem('print');" style="margin:20px;">Տպել</button>
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