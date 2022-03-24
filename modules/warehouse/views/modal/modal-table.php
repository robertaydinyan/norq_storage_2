<div class="w-50 m-auto position-relative" role="document" style="top: 50px;">
    <div class="modal-content">
        <form method="post" action="/warehouse/warehouse/change-table-rows">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-wrench mr-3"></i>Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="d-flex justify-content-between" style="width: 98%;margin-left:1%">
                <div class="d-flex flex-column " style="width: 22%;">
                    <label>asas</label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                        <div class="input-group-prepend">
                            <div class="input-group-text" id="btnGroupAddon">count pages</div>
                        </div>
                    </div>
                    <p>asdasdasd</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <label>asas</label>
                    <input type="text" class="form-control">
                    <p>asdasdasd</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <label>asas</label>
                    <input type="text" class="form-control">
                    <p>asdasdasd</p>
                </div>
                <div class="d-flex flex-column" style="width: 22%;">
                    <label>asas</label>
                    <input type="text" class="form-control">
                    <p>asdasdasd</p>
                </div>
            </div>
            <label class=" text-center border-bottom border-top mt-3 p-2" style="width: 98%;margin-left:1%">kargavorumner</label>
            <div class="modal-body d-flex justify-content-between" >
                <div class="d-flex flex-column sortable connectedSortable modal-table" >
                    <label class="modal-label">Tesaneli syuner</label>
                    <?php if(isset($columnsActive)):
                        foreach ($columnsActive as $c): ?>
                            <span><i class="fa fa-eye mr-2"></i><?php echo $c->row_name; ?>
                                <input type="hidden" name="row[id][]" value="<?php echo $c->id; ?>">
                            </span>
                        <?php endforeach;
                    endif; ?>
                </div>
                <input type="hidden" name="row[id][]" value="passive-data">
                <div style="width: 5%;text-align: center"><i class='fas fa-arrows-alt-h' style="font-size: 35px"></i></div>
                <div class="d-flex flex-column sortable connectedSortable modal-table" >
                    <label class="modal-label">Antesaneli syuner</label>
                    <?php if(isset($columnsPassive)):
                        foreach ($columnsPassive as $c): ?>
                            <span class="draggable " ><i class="fa fa-eye-slash mr-2"></i><?php echo $c->row_name; ?>
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
        background: #1b55e2;
        font-size: 18px;
        line-height: 40px;
    }
</style>
<script>
    $( ".sortable" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
</script>