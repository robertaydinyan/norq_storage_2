<?php if(!empty($products)){ 
    foreach ($products as $key => $value) { ?>
        
<div class="row product-form module-service-form-card justify-content-between align-items-center" style="position:relative;">
    <div class="row col-12	col-sm-12	col-md-12 col-lg-6	col-xl-6 d-flex justify-content-between align-items-center" style="padding: 0">
        <div class="form-group field-product-nomenclature_product_id required col-12	col-sm-12	col-md-12 col-lg-4	col-xl-4">
            <label class="control-label" for="product-nomenclature_product_id">Ապրանք</label>
             <input type="text" class="form-control"  value="<?=$value->nProduct->name_hy?>" autocomplete="off">
             <input type="hidden" name="Product[nomenclature_product_id][]" class="namiclature_id" value="<?=$value->nProduct->id?>">
        </div>
        <div class="form-group field-product-price col-12	col-sm-12	col-md-12 col-lg-4	col-xl-4">
            <label class="control-label" for="product-price">Գին</label>
            <input type="number" class="form-control price__" value="<?=$value->price?>" name="Product[price][]" autocomplete="off">
        </div>
        <div class="form-group field-product-price col-12	col-sm-12	col-md-12 col-lg-4	col-xl-4">
            <label class="control-label" for="product-price">Արժույթ</label>
            <select class="form-control currency__ currency-input" onchange="showTotal($(this))" name="Product[currency][]" id="">
              <option value="3" data-value="1">֏</option>            
           </select>
        </div>
        <input type="hidden" class="form-control" name="Product[retail_price][]" autocomplete="off" value="<?=$value->retail_price?>">
    </div>
    <div class=" row col-12	col-sm-12	col-md-12 col-lg-6	col-xl-4 d-flex justify-content-between align-items-center" style="padding: 0">
        <div class="form-group field-product-comment col-12	col-sm-12	col-md-12 col-lg-6	col-xl-6">
            <label class="control-label" for="product-comment">Մեկնաբանություն</label>
            <input type="text" id="product-comment" value="<?=$value->comment?>" class="form-control" name="Product[comment][]" maxlength="255" novalidate="" autocomplete="off">
        </div>
        <div class="form-group field-product-count col-12	col-sm-12	col-md-12 col-lg-6	col-xl-6">
            <label class="control-label" for="product-count">Քանակ</label>
            <input type="text" value="<?=$value->count?>" class="form-control product-count" onchange="showTotal($(this))" name="Product[count][]" autocomplete="off">
        </div>
       
    </div>
    <div class="row col-12	col-sm-12	col-md-12 col-lg-6	col-xl-2 d-flex justify-content-between align-items-center" style="padding: 0">
        <div class="form-group field-product-mac_address hide col-sm-6">
            <label class="control-label" for="product-count">Mac հասցե</label>
            <div class="row cloned-mac">
                <div class="col-sm-9">
                    <input type="text" class="form-control mac" name="Product[mac_address][1][]">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-primary btn-sm clone-mac" type="button"><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-sm-1 hide" style="margin-left:5px;">
                    <button class="btn btn-danger btn-sm remove-mac" onclick="$(this).closest('.cloned-mac').remove()" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" name="Product[notice_if_move][]" class="is_vip" value="">
         <div class="form-group field-product-count col-sm-12">
            <label class="control-label" for="product-count">Ընդանուր</label>
            <input type="text" class="form-control product-price-total" onchange="showTotal($(this))" autocomplete="off">
        </div>
    </div>
    <div class="row col-12	col-sm-12	col-md-12 col-lg-6	col-xl-2" style="padding: 0; position: absolute; width: 90px; top: 2px; right: 4px;">
        <div class="rem" style="position: absolute; right: 100px; cursor:pointer;" onclick="$(this).closest('.product-form').remove()"><i style="color:red;font-size:30px;" class="fa fa-times"></i></div>
        <button class="btn btn-primary clone-product" type="button"><i class="fa fa-plus"></i></button>
    </div>
</div>
<br>
<?php } } ?>

<div class="row product-form module-service-form-card justify-content-between align-items-center" style="position:relative;">
    <div class="row col-12  col-sm-12   col-md-12 col-lg-6  col-xl-6 d-flex justify-content-between align-items-center" style="padding: 0">
        <div class="form-group field-product-nomenclature_product_id required col-12    col-sm-12   col-md-12 col-lg-4  col-xl-4">
            <label class="control-label" for="product-nomenclature_product_id">Ապրանք</label>
             <input type="text" class="form-control" onfocus="selectProductNamiclature($(this))" required="required">
             <input type="hidden" name="Product[nomenclature_product_id][]" class="namiclature_id">
        </div>
        <div class="form-group field-product-price col-12   col-sm-12   col-md-12 col-lg-4  col-xl-4">
            <label class="control-label" for="product-price">Գին</label>
            <input type="number" class="form-control price__" onchange="showTotal($(this)" name="Product[price][]" autocomplete="off">
        </div>
        <div class="form-group field-product-price col-12   col-sm-12   col-md-12 col-lg-4  col-xl-4">
            <label class="control-label" for="product-price">Արժույթ</label>
            <select class="form-control currency__ currency-input" onchange="showTotal($(this))" name="Product[currency][]" id="">
                <option value="" disabled="" selected=""></option>
                <option value="1" data-value="473.13">$</option><option value="2" data-value="5.96">₽</option><option value="3" data-value="1">֏</option>            </select>
        </div>
        <input type="hidden" class="form-control" name="Product[retail_price][]" autocomplete="off">
    </div>
    <div class=" row col-12 col-sm-12   col-md-12 col-lg-6  col-xl-4 d-flex justify-content-between align-items-center" style="padding: 0">

        <div class="form-group field-product-comment col-12 col-sm-12   col-md-12 col-lg-6  col-xl-6">
            <label class="control-label" for="product-comment">Մեկնաբանություն</label>
            <input type="text" id="product-comment" class="form-control" name="Product[comment][]" maxlength="255" novalidate="" autocomplete="off">
        </div>
        <div class="form-group field-product-count col-12   col-sm-12   col-md-12 col-lg-6  col-xl-6">
            <label class="control-label" for="product-count">Քանակ</label>
            <input type="text" class="form-control product-count" onchange="showTotal($(this))" name="Product[count][]" autocomplete="off">
        </div>
       
    </div>
    <div class="row col-12  col-sm-12   col-md-12 col-lg-6  col-xl-2 d-flex justify-content-between align-items-center" style="padding: 0">
        <div class="form-group field-product-mac_address hide col-sm-6">
            <label class="control-label" for="product-count">Mac հասցե</label>
            <div class="row cloned-mac">
                <div class="col-sm-9">
                    <input type="text" class="form-control mac" name="Product[mac_address][0][]">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-primary btn-sm clone-mac" type="button"><i class="fa fa-plus"></i></button>
                </div>
                <div class="col-sm-1 hide" style="margin-left:5px;">
                    <button class="btn btn-danger btn-sm remove-mac" onclick="$(this).closest('.cloned-mac').remove()" type="button"><i class="fa fa-minus"></i></button>
                </div>
            </div>
        </div>
        <input type="hidden" name="Product[notice_if_move][]" class="is_vip" value="0">
         <div class="form-group field-product-count col-sm-12">
            <label class="control-label" for="product-count">Ընդանուր</label>
            <input type="text" class="form-control product-price-total" onchange="showTotal($(this))" autocomplete="off">
        </div>
    </div>
    <div class="row col-12  col-sm-12   col-md-12 col-lg-6  col-xl-2" style="padding: 0; position: absolute; width: 90px; top: 2px; right: 4px;">
        <div class="rem hide" style="position: absolute; right: 100px; cursor:pointer;" onclick="$(this).closest('.product-form').remove()"><i style="color:red;font-size:30px;" class="fa fa-times"></i></div>
        <button class="btn btn-primary clone-product" type="button"><i class="fa fa-plus"></i></button>
    </div>
</div>

