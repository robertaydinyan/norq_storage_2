<div class="w-75 m-auto position-relative" role="document" style="top: 50px;">
    <div class="modal-content">
        <form method="post" action="/warehouse/warehouse/change-table-rows">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-wrench mr-3"></i>Անհատականացրեք աղյուսակի պարամետրերը</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="d-flex justify-content-between" style="width: 98%;margin-left:1%">
                <div class="d-flex flex-column " style="width: 22%;">
                    <h6>Էջերի քանակը</h6>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="0-50" aria-label="Input group example" aria-describedby="btnGroupAddon">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">Տողերի քանակը</div>
                        </div>
                    </div>
                    <p style="font-size: 13px">Թիվը 0-ից մինչև 50</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <h6>Աղյուսակի տեսք *</h6>
                    <input type="text" class="form-control">
                    <p style="font-size: 13px">Ընտրեք թեման աղյուսակի տեսքի համար</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <h6>Հիմնական ֆիլտր</h6>
                    <input type="text" class="form-control">
                    <p style="font-size: 13px">Սահմանեք աղյուսակի ֆիլտրի հիմնական չափանիշները</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <h6> Հիմնական տեսակավորում</h6>
                    <input type="text" class="form-control">
                    <p style="font-size: 13px">Սահմանեք աղյուսակի տեսակավորման հիմնական չափանիշները</p>
                </div>
            </div>
            <h6 class=" text-center border-bottom border-top mt-3 p-2" style="width: 98%;margin-left:1%">Կարգավորեք աղյուսակի սյուների կարգը և ցուցադրումը</h6>
            <div class="modal-body d-flex justify-content-between" >
                <div class="d-flex flex-column sortable connectedSortable modal-table" >
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
                <div style="width: 5%;text-align: center"><i class='fas fa-arrows-alt-h' style="font-size: 35px"></i></div>
                <div class="d-flex flex-column sortable connectedSortable modal-table" >
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
    $( ".sortable" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
</script>