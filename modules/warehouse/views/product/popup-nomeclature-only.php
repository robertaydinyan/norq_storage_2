<?php
$this->registerCssFile('@web/css/modules/warehouse/zTreeStyle.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/jquery.ztree.core.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

    <SCRIPT type="text/javascript">
        <!--
        var zTree;
        var demoIframe;

        var setting = {
            view: {
                dblClickExpand: false,
                showLine: true,
                selectedMulti: false
            },
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "pId",
                    rootPId: ""
                }
            },
            callback: {
                beforeClick: function (treeId, treeNode) {
                    var zTree = $.fn.zTree.getZTreeObj("tree");
                    if (treeNode.isParent) {
                        zTree.expandNode(treeNode);
                        return false;
                    } else {
                        demoIframe.attr("src", treeNode.file + ".html");
                        return true;
                    }
                }
            }
        };



        function loadReady() {
            var bodyH = demoIframe.contents().find("body").get(0).scrollHeight,
                htmlH = demoIframe.contents().find("html").get(0).scrollHeight,
                maxH = Math.max(bodyH, htmlH), minH = Math.min(bodyH, htmlH),
                h = demoIframe.height() >= maxH ? minH : maxH;
            if (h < 530) h = 530;
            demoIframe.height(h);
        }

        //-->
    </SCRIPT>
<div class="modal fade" id="viewInfoNom" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-modal="true" style="display: block;">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="float-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <div class="mod-content">
                    <input type="hidden" name="nomiclature_id" id="nomiclature_id">
                    <script>
                        var zNodes = [
                             <?php foreach ($tableTreeGroups as $tableTreeGroup) : ?>
                             {id: <?= $tableTreeGroup['id'] ?>, pId: 0, name: "<?= $tableTreeGroup['name'] ?>", open: false},
                                        <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/product/tree_table_nom_only.php', [
                                            'tableTreeGroup' => $tableTreeGroup,
                                        ]); ?>
                            <?php endforeach; ?>
                        ];
                    </script>
                    <TABLE border=0 height=600px align=left>
                        <TR>
                            <TD width=460px align=left valign=top style="BORDER-RIGHT: #999999 1px dashed">
                                <ul id="tree" class="ztree" style="width:460px; overflow:auto;"></ul>
                            </TD>
                            <TD align=left valign=top>
                                <div id="products" class="ztree" style="width:460px
                                ; overflow:auto;"></div>
                            </TD>
                        </TR>
                    </TABLE>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
console.log(zNodes)
        var t = $("#tree");
        t = $.fn.zTree.init(t, setting, zNodes);
        demoIframe = $("#testIframe");
        demoIframe.bind("load", loadReady);
        var zTree = $.fn.zTree.getZTreeObj("tree");
        zTree.selectNode(zTree.getNodeByParam("id", 101));
        // setTimeout(function(){
        //     $('#tree a').each(function(){
        //         $(this).attr('data-url', $(this).attr('href'));
        //
        //         // $(this).removeAttr('href');
        //     });
        // },1200);

    });
    $('#viewInfoNom').modal('show');
</script>
<style>
    .ztree *{
        font-size: 16px !important;
    }
</style>