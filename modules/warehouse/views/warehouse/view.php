<?php

use app\modules\warehouse\models\Warehouse;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $dataProvider app\modules\warehouse\models\Warehouse */
/* @var $searchModel app\modules\warehouse\models\Warehouse */

$this->title = array(Yii::t('app', 'Main warehouse'), 'Main warehouse');
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/js/lightgallery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>


<style>
    thead input {
        width: 100%;
    }

    th, td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
    }
</style>
<div class="warehouse-view d-flex flex-wrap group-product-index" style="padding: 20px;">
    <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-4">
        <h1 class="mb-5 d-flex"
            data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($model->name) ?><span
                    class="star"><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-hover'],
            'attributes' => [
                'name',
                'address',
                [
                    'label' => Yii::t('app', 'Warehouse type'),
                    'value' => $model->getType($model->type)->name
                ],
                [
                    'label' => Yii::t('app', 'storekeeper'),
                    'value' => function ($model) {
                        $user = $model->getUser($model->responsible_id);
                        return $user->name . ' ' . $user->last_name;
                    }
                ],
                [
                    'label' => Yii::t('app', 'Created'),
                    'value' => function ($model) {
                        return date('d.m.Y', strtotime($model->created_at));
                    }
                ],
            ],
        ]) ?>
        <?php if (\Yii::$app->user->can('admin')) { ?>
            <p>
                <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        <?php } ?>
    </div>
    <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-7 table-scroll" style="margin-top:36px;"
         id="lightgallery">

        <table class="table table-hover  detail-view " style="width:100%">
            <thead>
            <?php if (!empty($dataProvider['result'])) : ?>
            <tr>
                <th><?php echo Yii::t('app', 'Warehouse name'); ?></th>
                <th><?php echo Yii::t('app', 'Product name'); ?></th>
                <th><?php echo Yii::t('app', 'Quantity'); ?></th>
                <th><?php echo Yii::t('app', 'Individual'); ?></th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($dataProvider['result'] as $key => $products) : ?>
                <tr data-src="https://sachinchoolur.github.io/lightgallery.js/static/img/1-1600.jpg">
                    <td><?php echo $products['wname']; ?></td>
                    <td><a href="#" onclick="showPage('/warehouse/nomenclature-product/view?id=<?= $products['nomenclature_product_id'] ?>','<?= $products['nomeclature_name'] ?>')"
                          ><?= $products['nomeclature_name'] ?></a></td>

                    <td><a href="#" data-toggle="modal" data-target="#viewInfo"
                           onclick="showInfo(<?= $products['nid'] ?>,<?php echo $products['id']; ?>)"><?= $products['count_n_product'] ?> <?= $products['qtype'] ?> </a>
                    </td>
                    <td><?php if ($products['individual'] == 'true') {
                            echo Yii::t('app', 'Yes');
                        } else {
                            echo Yii::t('app', 'No');
                        } ?></td>
                </tr>
            <?php endforeach; ?>

            </tbody>
            <?php endif; ?>

        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                for ($page = 1; $page <= $dataProvider['total']; $page++) {
                    $active = '';
                    if (isset($_GET['page']) && $page == intval($_GET['page'])) {
                        $active = 'active';
                    }
                    echo '<li class="page-item ' . $active . '"><a class="page-link " href="/warehouse/warehouse/view?id=' . $model->id . '&page=' . $page . '&lang=' . Yii::$app->language . '">' . $page . '</a></li>';
                }
                ?>
            </ul>
        </nav>
        <div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="mod-content"></div>
                    </div>
                </div>

            </div>
        </div>


    </div>


</div>

</div>
<script>
    function showInfo(id, wid) {
        if (id) {
            $.ajax({
                url: '/warehouse/warehouse/get-product-info',
                method: 'get',
                dataType: 'html',
                data: {id: id, wid: wid},
                success: function (data) {
                    $('.mod-content').html(data);
                }
            });
        }
    }
</script>