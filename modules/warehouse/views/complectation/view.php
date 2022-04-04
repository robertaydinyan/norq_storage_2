<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */

$this->title = array($model->name.  ' '  .$model->id, $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Complectations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$lang = explode('-', \Yii::$app->language)[0] ?: 'hy';
?>
 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<div class="group-product-index">

    <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>

    <div style="padding:20px;" >
        <div class="row">
            <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-4 table-scroll">
                <?= DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-hover'],
                    'attributes' => [
                        'id',
                        'price',
                        'name',
                        'count',[
                            'label' => Yii::t('app', 'Created'),
                            'value' => function ($model) {
                                return date('d.m.Y',strtotime($model->created_at));
                            }
                        ],
                        'warehouse_id',
                    ],
                ]) ?>
            </div>
            <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-7 table-scroll" style="margin-top:50px;">
                <table id="products" class="display nowrap" style="width:100%;">
                    <thead>
                    <?php if (!empty($whProducts)) : ?>
                    <tr>
                        <th><?php echo Yii::t('app', 'Name'); ?></th>
                        <th><?php echo Yii::t('app', 'Count'); ?></th>
                        <th><?php echo Yii::t('app', 'Series'); ?></th>
                        <th><?php echo Yii::t('app', 'Individual'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($whProducts as $products) : ?>

                        <tr>
                            <td><?= $products['nProduct']['name_' . $lang] ?></td>
                            <?php if ($products['nProduct']['individual'] == 'false') : ?>
                                <td><?= $products['n_product_count'] ?> <?= $products['nProduct']['qtyType']['type_' . $lang] ?></td>
                            <?php else : ?>
                                <td><a href="#"  onclick="showLog('<?= $products->product['mac_address']?>')"><?= $products['n_product_count'] ?> <?= $products['nProduct']['qtyType']['type_' . $lang] ?> </a></td>
                            <?php endif; ?>
                            <td  onclick="showLog('<?= $products->product['mac_address']?>')"><?= $products->product['mac_address']?></td>
                            <td><?php if($products['nProduct']['individual']=='true'){ echo 'Այո';} else { echo 'Ոչ';} ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <?php endif; ?>

                </table>
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

</div>
<?php if (!empty($whProducts)) : ?>
    <script>
        $('#products').DataTable( {
            dom: 'Bfrtip',
            buttons: [
               'csv', 'excel'
            ],
            className: 'text-white',
            "oLanguage": {
                "sSearch": "<?php echo Yii::t('app', 'search'); ?>"
            },
            "language": {
                "paginate": {
                    "previous": "<?php echo Yii::t('app', 'Previous'); ?>",
                    "next": "<?php echo Yii::t('app', 'Next'); ?>",
                }
            }
        } );
    </script>
<?php endif; ?>