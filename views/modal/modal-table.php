<div class="w-75 m-auto position-relative" role="document" style="top: 50px;">
    <div class="modal-content">
        <form method="post" action="/warehouse/warehouse/change-table-rows" class=" pb-3">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-wrench mr-3"></i>Անհատականացրեք աղյուսակի պարամետրերը</h5>
                <button type="button" class="" data-dismiss="modal" aria-label="Close" style="background: #0055a5!important;color: #fff!important;">
                    <span aria-hidden="true" style="color: #fff!important;">&times;</span>
                </button>
            </div>
            <div class="d-flex justify-content-between row bg-white" style="width: 98%;margin-left:1%">
                <div class="d-flex flex-column col-12	col-sm-12	col-md-12 col-lg-6	col-xl-3" style="width: 22%;">
                    <h6>Էջերի քանակը</h6>
                    <div class="input-group">
                        <input name="rows-count" type="number" class="form-control" placeholder="0-50" aria-label="Input group example" aria-describedby="btnGroupAddon" value="<?php echo $rows_count->count; ?>">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">Տողերի քանակը</div>
                        </div>
                    </div>
                    <p style="font-size: 13px">Թիվը 0-ից մինչև 50</p>
                </div>
                <div class="d-flex flex-column col-12	col-sm-12	col-md-12 col-lg-6	col-xl-3" style="width: 22%;">
                    <h6>տողերը դասավորել ըստ</h6>
                    <div style="display: flex;">
                        <select name="sort-column" id="" class="form-control" name="sort-column">
                            <?php if(isset($columnsActive) || isset($columnsPassive)):
                                foreach (array_merge($columnsActive, $columnsPassive) as $c):
                                    if ($c->row_name == "barcode") continue; ?>
                                    <option value="<?php echo $c->row_name; ?>"
                                        <?php echo $rows_count->column_name == $c->row_name ? 'selected' : ''; ?>
                                    ><?php echo Yii::t('app', $c->row_name_normal); ?></option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                        <input type="hidden" name="sort-direction" value="<?php echo $rows_count->direction == 'DESC' ? 'DESC' : 'ASC'; ?>">
                        <button type="button" class="sort-direction" data-sort="<?php echo $rows_count->direction == 'DESC' ? 'DESC' : 'ASC'; ?>">
                            <i class="fa <?php echo $rows_count->direction == 'DESC' ? 'fa-arrow-up' : 'fa-arrow-down'; ?>" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="col-xl-6"></div>
<!--                <div class="d-flex flex-column col-12	col-sm-12	col-md-12 col-lg-6	col-xl-3" style="width: 22%;">-->
<!--                    <h6>Աղյուսակի տեսք *</h6>-->
<!--                    <input type="text" class="form-control">-->
<!--                    <p style="font-size: 13px">Ընտրեք թեման աղյուսակի տեսքի համար</p>-->
<!--                </div>-->
<!--                <div class="d-flex flex-column col-12	col-sm-12	col-md-12 col-lg-6	col-xl-3" style="width: 22%;">-->
<!--                    <h6>Հիմնական ֆիլտր</h6>-->
<!--                    <input type="text" class="form-control">-->
<!--                    <p style="font-size: 13px">Սահմանեք աղյուսակի ֆիլտրի հիմնական չափանիշները</p>-->
<!--                </div>-->
<!--                <div class="d-flex flex-column col-12	col-sm-12	col-md-12 col-lg-6	col-xl-3" style="width: 22%;">-->
<!--                    <h6> Հիմնական տեսակավորում</h6>-->
<!--                    <input type="text" class="form-control">-->
<!--                    <p style="font-size: 13px">Սահմանեք աղյուսակի տեսակավորման հիմնական չափանիշները</p>-->
<!--                </div>-->
            </div>
            <h6 class=" text-center border-bottom border-top  p-2 mb-0" style="width: 98%;margin-left:1%;background: #fff!important;">Կարգավորեք աղյուսակի սյուների կարգը և ցուցադրումը</h6>
            <div class="modal-body d-flex justify-content-between row" >
                <div class="d-flex flex-column sortable connectedSortable modal-table col-12 col-sm-12	col-md-12 col-lg-5	col-xl-5" >
                    <label class="modal-label">Տեսանելի սյուներ</label>
                    <?php if(isset($columnsActive)):
                        foreach ($columnsActive as $c): ?>
                            <span><i class="fa fa-eye mr-2"></i><?php echo Yii::t('app', $c->row_name_normal); ?>
                                <input type="hidden" name="row[id][]" value="<?php echo $c->id; ?>">
                            </span>
                        <?php endforeach;
                    endif; ?>
                </div>
                <input type="hidden" name="row[id][]" value="passive-data">
                <div style="width: 5%;text-align: center"><i class='fas fa-arrows-alt-h col-12 col-sm-12	col-md-12 col-lg-2	col-xl-2' style="font-size: 35px"></i></div>
                <div class="d-flex flex-column sortable connectedSortable modal-table col-12 col-sm-12	col-md-12 col-lg-5	col-xl-5" >
                    <label class="modal-label">Անտեսանելի սյուներ</label>
                    <?php if(isset($columnsPassive)):
                        foreach ($columnsPassive as $c): ?>
                            <span class="draggable " ><i class="fa fa-eye-slash mr-2"></i><?php echo Yii::t('app', $c->row_name_normal); ?>
                                <input type="hidden" name="row[id][]" value="<?php echo $c->id; ?>">
                            </span>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
            <div class="modal-footer ">
                <input class="btn btn-primary" type="submit" value="<?php echo Yii::t('app', 'Save');?>">
            </div>
        </form>
    </div>
</div>

<style>
    .modal-table {
        min-width: 300px;
        width: 40%;
        border: 1px solid #bcadad;
        padding: 10px;
    }
    .modal-table span {
        border:1px solid #bcadad;
        margin-bottom: 5px;
        padding: 5px 10px;
    }
    .modal-label {
        border:1px solid #bcadad;
        margin-bottom: 5px;
        padding-left: 10px;
        color: #fff;
        background: #007bff ;
        font-size: 18px;
        line-height: 40px;
    }
</style>
<script>
    $('.sort-direction').on('click', function() {
        if ($(this).attr('data-sort') === "ASC") {
            $(this).attr('data-sort', 'DESC');
            $(this).find('i').attr('class', 'fa fa-arrow-up');
        } else {
            $(this).attr('data-sort', 'ASC');
            $(this).find('i').attr('class', 'fa fa-arrow-down');
        }
        $(this).prev().val($(this).attr('data-sort'));
    });
    $( ".sortable" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
</script>