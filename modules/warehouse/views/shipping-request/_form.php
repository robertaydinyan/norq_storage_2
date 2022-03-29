<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Url;
use \app\modules\warehouse\models\Product;
use \app\modules\warehouse\models\ProductForRequest;
use \app\modules\warehouse\models\ShippingProducts;
use \app\modules\warehouse\models\Warehouse;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\ShippingRequest */
/* @var $dataWarehouses app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\ShippingRequest */
/* @var $nProducts app\modules\warehouse\models\Shipping */
/* @var $types app\modules\warehouse\models\ShippingType */
/* @var $dataUsers app\modules\warehouse\models\Shipping */
/* @var $form yii\widgets\ActiveForm */
/* @var $partners app\modules\warehouse\models\PartnersList */


$this->registerJsFile('@web/js/modules/warehouse/shipping_new.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/hr_assets/css/ui-kit.css', ['depends' => [\yii\bootstrap4\BootstrapAsset::className()],]);
$lang = Yii::$app->language;
$lang_s = explode('-', \Yii::$app->language)[0] ?: 'hy';

?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data','novalidate'=>'novalidate']]); ?>
<div class="row">
<div class="shipping-request-form col-sm-6">

    <?= $form->field($model, 'shipping_type', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $types,
        'maintainOrder' => true,
        'hideSearch' => true,
        'options' => [
            'placeholder' => Yii::t('app', 'Select'),
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'disabled' => !$model->isNewRecord,
        ],
    ]) ?>
     <div class="form-group field-shippingrequest-request_id hide ">
        <label class="control-label" for="product-invoice"><?php echo Yii::t('app', 'Purchase request'); ?></label>
        <input type="text" id="product-invoice" value="<?php echo $model->request_id;?>" class="form-control" name="ShippingRequest[request_id]" maxlength="255">
     </div>
 
      <div class="form-group date_">
        <label class="control-label" for="product-invoice"><?php echo Yii::t('app', 'Date'); ?></label>
        <?php if(!$model->isNewRecord){ ?>
            <input type="text" id="date_create" disabled value="<?php echo date('Y-m-d',strtotime($model->created_at));?>" class="form-control datepicker" name="ShippingRequest[date_create]" >
        <?php } else { ?>
            <input type="text" id="date_create"    class="form-control datepicker" name="ShippingRequest[date_create]" >
        <?php } ?>
    </div>
      <?php 
        if(\Yii::$app->user->can('technician') && !\Yii::$app->user->can('admin')) {
            $warehouseId = Warehouse::find()->where(['responsible_id'=>Yii::$app->user->getId()])->one()->id;
        ?>
           <div class="form-group field-shippingrequest-provider_warehouse_id">
                <label class="control-label" for="shippingrequest-provider_warehouse_id"><?php echo Yii::t('app', 'Transfer warehouse'); ?></label>
                <input type="text" id="shippingrequest-provider_warehouse_id" onfocus="selectWarehouse($(this), '<?php echo $lang; ?>')" disabled class="form-control" >
                <input type="hidden" name="ShippingRequest[provider_warehouse_id]" value="<?php echo $warehouseId;?>">
          </div>
        <script>
            window.onload = function(){
     
               $("#shippingrequest-provider_warehouse_id").val('65').trigger('change');
          
        }
        </script>
        <?php } else { ?>
         <div class="form-group field-shippingrequest-provider_warehouse_id">
            <label class="control-label" for="shippingrequest-provider_warehouse_id"><?php echo Yii::t('app', 'Transfer warehouse'); ?></label>
            <input type="text" id="shippingrequest-provider_warehouse_id" onfocus="selectWarehouse($(this), '<?php echo $lang; ?>')" class="form-control" >
            <input type="hidden" name="ShippingRequest[provider_warehouse_id]" >
      </div>
       <?php } ?>
        <div id="showWarehouse"></div>
       <div class="form-group field-shippingrequest-supplier_warehouse_id">
            <label class="control-label" for="shippingrequest-supplier_warehouse_id"><?php echo Yii::t('app', 'Supplier warehouse'); ?></label>
            <input type="text" id="shippingrequest-supplier_warehouse_id" onfocus="selectWarehouse($(this), '<?php echo $lang; ?>')" class="form-control" >
            <input type="hidden" name="ShippingRequest[supplier_warehouse_id]" >
      </div>
 
  
    <?= $form->field($model, 'user_id', [
        'options' => ['class' => 'form-group'],
    ])->widget(Select2::className(), [
        'theme' => Select2::THEME_KRAJEE,
        'data' => $dataUsers,
        'maintainOrder' => true,
        'hideSearch' => false,
        'options' => [
            'placeholder' => Yii::t('app', 'Select'),
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>
  

    <div class="form-group field-product-supplier_id hide for_sale">

        <label class="control-label" for="product-supplier_id">Գործընկեր <?php if(!$model->isNewRecord){ echo '`'.$model->partner['name'];}?></label>
        <div>
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($partners as $tableTreePartner) : ?>
                    <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name'] ?>" class="parent-block"><?= $tableTreePartner['name'] ?>
                        </span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_form_table.php', [
                                'tableTreePartner' => $tableTreePartner,
                                'checked' => $model->partner_id,
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
    <div class="form-group field-product-supplier_id hide for_bay">
        <label class="control-label" for="product-supplier_id"><?php echo Yii::t('app', 'Supplier'); ?> <?php if(!$model->isNewRecord){ echo '`'.$model->supplierp['name'];}?></label>

        <div>
            <ul class="file-tree" style="border:1px solid #dee2e6;padding: 30px;padding-top: 10px;margin-top:20px;">
                <?php foreach ($suppliers as $tableTreePartner) : ?>
                    <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name_' . $lang_s] ?>" class="parent-block"><?= $tableTreePartner['name_' . $lang_s] ?>
                        </span>
                        <ul style="display: block;">
                            <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_form_sup_table.php', [
                                'tableTreePartner' => $tableTreePartner,
                                'checked' => $model->supplier_id,
                            ]); ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>
    <?= $form->field($model, 'comment')->textarea(['rows' => '6']) ?>
    <div class="form-group field-product-invoice hide for_bay">
        <label class="control-label" for="product-invoice">Invoice</label>
        <input type="text" id="product-invoice" value="<?php echo $model->invoice;?>" class="form-control" name="ShippingRequest[invoice]" maxlength="255">
    </div>
</div>
<div class="shipping-request-form col-sm-6">
    <?php if($model->isNewRecord){ ?>
    <div class="hide-block"></div>
    <div id="product-add-block" class="product-add-block"></div>
    <div id="deal-addresses"  class="module-service-form-card border-primary position-relative col-md-12 mt-3">
        <div class="row product-block" >
            <div class="col-sm-4">
                <?= $form->field($model, 'nomenclature_product_id[]', [
                    'template' => '{input}{label}{error}{hint}',
                    'options' => ['class' => 'form-group sk-floating-label nm_products'],
                ])->widget(Select2::className(), [
                    'theme' => Select2::THEME_KRAJEE,
                    'data' => $nProducts,
                    'maintainOrder' => true,
                    'options' => [
                        'id' => 'nomenclature_product',
                        'class'=>'nm_products',
                        'placeholder' => Yii::t('app', 'Select')
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
             <div class="col-sm-3">
                <div class="form-group counts-input sk-floating-label field-shippingrequest-count">
                    <select name="ShippingRequest[nomenclature_product_id][]" class="ns_products form-control btn-primary" required="required" >
                        <option value=""></option>
                    </select>
                 <label class="control-label" for="shippingrequest-count"><?php Yii::t('app', 'Product'); ?></label><div class="help-block"></div>
                </div>
            </div>


            <div class="col-sm-3">
                <?= $form->field($model, 'count[]', [
                    'options' => ['class' => 'form-group counts-input sk-floating-label'],
                    'template' => '{input}{label}{error}{hint}'
                ])->textInput(['maxlength' => true,'type' => 'number','required'=>'required']) ?>
            </div>
             <div class="col-sm-2 hide">
                <div class="form-group counts-input sk-floating-label field-shippingrequest-tp">
                    <select name="ShippingRequest[action_type][]" class="tp form-control btn-primary" required="required" >
                        <option value="1"><?php echo Yii::t('app', 'Internet'); ?></option>
                        <option value="2">Ip</option>
                        <option value="3">Tv</option>
                    </select>
                 <label class="control-label" for="shippingrequest-tp"><?php Yii::t('app', 'Transaction type'); ?></label><div class="help-block"></div>
                </div>
            </div>
            <div class="col-sm-12 hide">
                <div class="form-group price-input sk-floating-label field-shippingrequest-price">
                    <input type="number" id="shippingrequest-price" class="form-control" name="ShippingRequest[price][]" required="required" autocomplete="off">
                    <label class="control-label" for="shippingrequest-price"><?php Yii::t('app', 'Sale price'); ?></label>
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="remove-address d-none float-right">
                    <span class="ui-btn ui-btn-xs ui-btn-danger card-action-btn-remove-address"><?= Yii::t('app', 'Delete') ?></span>
                </div>
            </div>
        </div>
        <div class="add-address">
            <span class="btn-add-product"><?php echo Yii::t('app', 'Add'); ?></span>
        </div>
    </div>
    <?php } else { ?>
       <?php
           if($model->shipping_type == 2 || $model->shipping_type == 6 || $model->shipping_type == 5 ) {
              if($model->shipping_type != 5){
                   $products = Product::find()->where(['shipping_id' => $model->id])->all();
               } else {
                   $products = ProductForRequest::find()->where(['shipping_id' => $model->id])->all();
               }
               ?>
               <table class="table table-hover mt-4" >
                   <thead>
                   <tr>
                       <th>ID</th>
                       <th><?php echo Yii::t('app', 'Product') ?></th>
                       <th><?php echo Yii::t('app', 'Count') ?></th>
                       <th><?php echo Yii::t('app', 'Individual') ?></th>
                       <th><?php echo Yii::t('app', 'Delete') ?></th>
                   </tr>
                   </thead>
                   <?php if(!empty($products)){?>
                       <tbody>
                       <?php foreach ($products as $product => $prod_val){?>
                           <tr>
                               <td><?php echo $prod_val['id'];?></td>
                               <td><?php echo $prod_val->nProduct->name;?></td>
                               <td><?php echo $prod_val['count'];?></td>
                               <td><?php if($prod_val->nProduct->individual == 'true' && isset($prod_val['mac_address'])){ echo @$prod_val['mac_address'];} ?></td>
                               <td>
                                 <?php if($model->shipping_type != 5){ ?>
                                  <button type="button" class="btn btn-sm btn-danger" onclick="deleteProduct(<?php echo $prod_val['id'];?>)"><i class="fa fa-trash"></i></button>
                                 <?php } else { ?>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteLogProduct(<?php echo $prod_val['id'];?>)"><i class="fa fa-trash"></i></button>
                                 <?php } ?>
                               </td>
                           </tr>
                       <?php } ?>
                       </tbody>
                   <?php } ?>
               </table>
               <div id="product-add-block" class="product-add-block" style="padding:17px;">
               </div>
           <?php } else {
               $products = ShippingProducts::find()->where(['shipping_id'=>$model->id])->all();
               ?>
               <div id="deal-addresses"  class="module-service-form-card border-primary position-relative col-md-12 mt-3">
                   <div class="row product-block hide" >
                       <div class="col-sm-12 mt-3">
                           <?= $form->field($model, 'nomenclature_product_id[]', [
                               'template' => '{input}{label}{error}{hint}',
                               'options' => ['class' => 'form-group sk-floating-label nm_products'],
                           ])->widget(Select2::className(), [
                               'theme' => Select2::THEME_KRAJEE,
                               'data' => [$prod_val->product_id=>$prod->nProduct->name],
                               'maintainOrder' => true,
                               'options' => [
                                   'id' => 'nomenclature_product',
                                   'class'=>'nm_products',
                                   'value'=>$prod_val->product_id,
                                   'placeholder' => Yii::t('app', 'Select')
                               ],
                               'pluginOptions' => [
                                   'allowClear' => true
                               ],
                           ]) ?>
                       </div>
                       <div class="col-sm-12">
                           <?= $form->field($model, 'count[]', [
                               'options' => ['class' => 'form-group counts-input sk-floating-label'],
                               'template' => '{input}{label}{error}{hint}'
                           ])->textInput(['maxlength' => true,'value'=>$prod_val->count,'type' => 'number','required'=>'required']) ?>
                       </div>

                   </div>
                   <?php foreach ($products as $product => $prod_val){?>
                       <?php $prod = Product::findOne($prod_val->product_id);
                       ?>
                       <div class="row product-block" >
                           <div class="col-sm-12 mt-3">
                               <label class="control-label" style="margin-bottom: 0px !important;"><?php echo Yii::t('app', 'Product Nomenclature'); ?></label>
                               <input type="text"  class="form-control"  value="<?php echo $prod->nProduct->{'name_' . $lang_s};?>" disabled="true" required="required" autocomplete="off">
                           </div>
                           <br>
                           <div class="col-sm-12">
                               <label class="control-label" style="margin-bottom: 0px !important;"><?php echo Yii::t('app', 'Count'); ?></label>
                               <input type="text"  class="form-control"  value="<?php echo $prod_val->count;?>" disabled="true" required="required" autocomplete="off">
                           </div>

                       </div>
                       <?php  if($product == count($products)-1){ ?>
                           <br>
                       <div class="add-address">
                           <span class="btn-add-product"><?php echo Yii::t('app', 'Add'); ?></span>
                       </div>
                       <?php } ?>
                   <?php } ?>
               </div>
           <?php }
        ?>
    <?php } ?>
</div>
    <div class="shipping-request-form col-sm-12">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary check-counts']) ?>
            <?php if(isset($type) && $type == 'create'): ?>
                <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary', 'onClick' => 'SaveForm($(this))'])  ?>
            <?php endif; ?>
        </div>
    </div>


</div>
<?php ActiveForm::end(); ?>
