<?php

use app\modules\warehouse\models\Warehouse;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Warehouse */
/* @var $dataProvider app\modules\warehouse\models\Warehouse */
/* @var $searchModel app\modules\warehouse\models\Warehouse */
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';

$this->title = array(Yii::t('app', 'Main warehouse') , 'Main warehouse' );
$this->params['breadcrumbs'][] = ['label' => 'Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
 

<style>
    thead input {
        width: 100%;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
    }
</style>
<div class="warehouse-view d-flex group-product-index" style="padding: 20px;">
    <div class="col-lg-4">
        <h1 class="mb-5 d-flex" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($model->{'name_' . $lang}) ?> <?php echo Yii::t('app', 'Main warehouse'); ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
        <?php if($model->type != 2){ ?>
        <?= DetailView::widget([
            'model' => $model,
                'options' => ['class' => 'table table-hover'],
            'attributes' => [
                'name_' . $lang,
                'address',
                [
                    'label' => Yii::t('app', 'Warehouse type'),
                    'value' => $model->getType($model->type)->{'name_' . $lang}
                ],
                [
                    'label' => Yii::t('app', 'storekeeper'),
                    'value' => function ($model) {
                        $user = $model->getUser($model->responsible_id);
                        return $user->name.' '.$user->last_name;
                    }
                ],
                [
                    'label' => Yii::t('app', 'Created'),
                    'value' => function ($model) {
                        return date('d.m.Y',strtotime($model->created_at));
                    }
                ],
            ],
        ]) ?>
        <?php } else {
            echo DetailView::widget([
                'model' => $model,
                'options' => ['class' => 'table table-hover'],
                'attributes' => [
                    'name_' . $lang,
                    [
                        'label' => Yii::t('app', 'Warehouse type'),
                        'value' => $model->getType($model->type)->{'name_' . $lang}
                    ],
                    [
                        'label' => Yii::t('app', 'storekeeper'),
                        'value' => function ($model) {
                            $user = $model->getUser($model->responsible_id);
                            return $user->name . ' ' . $user->last_name;
                        }
                    ],
                    'created_at',
                ],
            ]);
        } ?>
        <?php if(\Yii::$app->user->can('admin')){ ?>
        <p>
            <?= Html::a(Yii::t('app', 'Change'), ['update', 'id' => $model->id, 'lang' => \Yii::$app->language], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id, 'lang' => \Yii::$app->language], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app','Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
       <?php } ?>
    </div>
    <div class="col-lg-7" style="margin-left: 50px;margin-top:36px;">

        <table  class="table table-hover  detail-view" style="width:100%">
            <thead>
            <?php if (!empty($dataProvider['result'])) : ?>
            <tr>
                <th><?php echo Yii::t('app','Warehouse name'); ?></th>
                <th><?php echo Yii::t('app','Product name'); ?></th>
                <th><?php echo Yii::t('app','Product Picture'); ?></th>
                <th><?php echo Yii::t('app','Quantity'); ?></th>
                <th><?php echo Yii::t('app','Individual'); ?></th>
            </tr>
            </thead>
            <tbody>
                
            <?php foreach ($dataProvider['result'] as $key => $products) : ?>
                <tr>
                     <td><?php if($products['type'] != 4){ echo $products['wname'];} else {
                        echo Warehouse::getContactAddressById($products['contact_address_id']);
                     } ?></td>
                    <td><?= $products['nomeclature_name'] ?></td>
                    <td><a target="_blank" href="<?= $products['img'] ?>" ><img width="100" src="<?= $products['img'] ?>"></a></td>
                    <?php if ($products['individual'] == 'false') : ?>
                        <td><?= $products['count_n_product'] ?> <?= $products['qtype'] ?></td>
                    <?php else : ?>
                        <td><a href="#" data-toggle="modal" data-target="#viewInfo" onclick="showInfo(<?= $products['nid'] ?>,<?php echo $products['id'];?>)"><?= $products['count_n_product'] ?> <?= $products['qtype'] ?> </a></td>
                    <?php endif; ?>
                      <td><?php if($products['individual']=='true'){ echo Yii::t('app', 'Yes');} else { echo Yii::t('app', 'No');} ?></td>
                </tr>
            <?php endforeach; ?>
   
            </tbody>
            <?php endif; ?>
         
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination">
            <?php 
                for($page = 1; $page<= $dataProvider['total']; $page++) {  
                       $active = '';
                       if(isset($_GET['page']) && $page == intval($_GET['page'])){
                          $active = 'active';
                       }
                        echo '<li class="page-item '.$active.'"><a class="page-link " href="/warehouse/product?page=' . $page . '&lang=' . Yii::$app->language . '">' . $page . '</a></li>';
                    }
               ?>
          </ul>
        </nav>
 <div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    function showInfo(id,wid){
    if(id){
        $('.hide-block').hide();
        $.ajax({
            url: '/warehouse/warehouse/get-product-info',
            method: 'get',
            dataType: 'html',
            data: { id: id,wid:wid},
            success: function (data) {
                $('.mod-content').html(data);
            }
        });
    }
}
</script>

