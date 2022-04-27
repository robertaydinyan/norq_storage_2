<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\Complectation */

$this->title = array($model->name, $model->name);
$this->params['breadcrumbs'][] = ['label' => 'Complectations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title[0];
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/product.js', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>

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
                        'other_cost',
                    ],
                ]) ?>
            </div>
            <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-7 table-scroll" >
                <table class="table table-bordered" style="width:100%;">
                    <thead>
                    <?php if (!empty($whProducts)) : ?>
                    <tr>
                        <th><?php echo Yii::t('app', 'Name'); ?></th>
                        <th><?php echo Yii::t('app', 'Count'); ?></th>
                        <th><?php echo Yii::t('app', 'Price'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($whProducts as $products) : ?>
                   
                        <tr>
                            <td><?= $products['nProduct']['name'] ?></td>
                            <td>
                                <?= $products['n_product_count'] ?> <?= $products['nProduct']['qtyType']['type'] ?>
                            </td>
                            <td><?= $products['price']?>Դ</td>

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
               'csv', 'excel',
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