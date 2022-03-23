<div class="modal-dialog" role="document">
    <div class="modal-content">
        <form method="post" action="/warehouse/warehouse/change-table-rows">
            <input type="hidden" name="_csrf" value="<?php echo Yii::$app->request->csrfToken; ?>">
            <input type="hidden" name="page" value="<?php echo $page; ?>">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="display:flex;">
                <div class="d-flex flex-column sortable connectedSortable" style="min-width: 300px">
                    <?php if(isset($columnsActive)):
                        foreach ($columnsActive as $c): ?>
                            <span class="ui-state-default"><?php echo $c->row_name; ?>
                                <input type="hidden" name="row[id][]" value="<?php echo $c->id; ?>">
                            </span>
                        <?php endforeach;
                    endif; ?>
                </div>
                <input type="hidden" name="row[id][]" value="passive-data">
                <div class="d-flex flex-column sortable connectedSortable" style="min-width: 300px">
                    <?php if(isset($columnsPassive)):
                        foreach ($columnsPassive as $c): ?>
                            <span class="draggable ui-state-highlight" ><?php echo $c->row_name; ?>
                                <input type="hidden" name="row[id][]" value="<?php echo $c->id; ?>">
                            </span>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="<?php echo Yii::t('app', 'Save');?>">
            </div>
        </form>
    </div>
</div>

<style>
    .ui-state-default {
        font-size: 20px;
        padding: 12px;
    }
</style>
<script>
    $( ".sortable" ).sortable({
        connectWith: ".connectedSortable"
    }).disableSelection();
</script>