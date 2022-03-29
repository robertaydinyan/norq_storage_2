<?php
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\ShippingType;
use app\modules\warehouse\models\Warehouse;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;

 $this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/crm/contact.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
 ?>
<?php 

$model_shipp = new ShippingRequest();
$dataWarehouses = ArrayHelper::map(Warehouse::find()->asArray()->all(), 'id', 'name');
$types = ArrayHelper::map(ShippingType::find()->where(['id'=>9])->orWhere(['id'=>7])->orWhere(['id'=>10])->asArray()->all(), 'id','name');
 ?>
<div class="shipping-request-create group-product-index">
  
  <div id="deal-addresses"  class="module-service-form-card border-primary position-relative col-md-12 mt-3">
    <h3>Պահեստ</h3>
      <div class="row" >
        <div class="col-sm-6 ">
                  <?=Select2::widget([
                'name' => 'ShippingRequest[shipping_type]',
                'model'=>$model_shipp,
                'data' => $types,
                'maintainOrder' => true,
                'hideSearch' => true,
                'options' => [
                    'id' => 'shippingrequest-shipping_type',
                    'placeholder' => Yii::t('app', 'Ընտրել տեսակ'),
                ],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        </div>
          <div class="col-sm-6 ">
              <?= Select2::widget( [
                  'name' => 'ShippingRequest[provider_warehouse_id]',
                  'data' => $dataWarehouses,
                  'model'=>$model_shipp,
                  'maintainOrder' => true,
                  'options' => [
                      'id' => 'shippingrequest-for-deal',  
                      'placeholder' => Yii::t('app', 'Ընտրել պահեստ'),
                  ],
                  'pluginOptions' => [
                      'allowClear' => true,
                  ],
              ]) ?>
          </div>

      </div>
    <div class="clearfix"></div>
    <br>
    <div class="row product-block" >
    
           
        <div class="col-sm-4 ">
            <?= Select2::widget([
                'name' => 'ShippingRequest[nomenclature_product_id][]',
                'model'=>$model_shipp,
                'data' => [],
                'maintainOrder' => true,
                'options' => [
                    'class'=>'nm_products',
                    'placeholder' => Yii::t('app', 'Ընտրել ապրանք')
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
                 <label class="control-label" for="shippingrequest-count">Ապրանք</label><div class="help-block"></div>
                </div>            
            </div>
        <div class="col-sm-3">
           <div class="form-group counts-input field-shippingrequest-count">
            <input type="number" placeholder="Քանակ" id="shippingrequest-count" class="form-control" name="ShippingRequest[count][]"  autocomplete="off">
            <div class="help-block"></div>
            </div>
        </div>
         <div class="col-sm-2 hide">
                <div class="form-group counts-input sk-floating-label field-shippingrequest-tp">
                    <select name="ShippingRequest[action_type][]" class="tp form-control btn-primary" required="required" >
                        <option value="1">Ինտերնետ</option>
                        <option value="2">Ip</option>
                        <option value="3">Tv</option>
                    </select>
                 <label class="control-label" for="shippingrequest-tp">Գործ․ տեսակ</label><div class="help-block"></div>
                </div>            
        </div>
        <div class="col-sm-4 hide bay_price">
            <div class="form-group price-input field-shippingrequest-price">
                <label class="control-label" for="shippingrequest-price">Վաճառքի գին</label>
                <input type="number" id="shippingrequest-price" class="form-control" name="ShippingRequest[price][]" autocomplete="off">
                <div class="help-block"></div>
            </div>
        </div>
   
    </div>
    <div class="add-address__">
        <span class="btn-add-product__" style="cursor:pointer;">Ավելացնել</span>
    </div>
</div>
</div>


<script>
    window.onload = function(){
           $('#shippingrequest-shipping_type').on('change',function(){
              if($(this).val() == 9){
                 $('.bay_price').removeClass('hide');
                 $('.field-shippingrequest-tp').closest('.col-sm-2').addClass('hide');
              } else {
                $('.field-shippingrequest-tp').closest('.col-sm-2').removeClass('hide');
                $('.bay_price').addClass('hide');
              }
           });

    }
</script>
