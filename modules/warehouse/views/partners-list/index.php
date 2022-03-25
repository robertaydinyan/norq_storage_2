<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\SearchPartnersList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = array(Yii::t('app', 'co-workers'), 'co-workers');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
?>
<?php if(\app\rbac\WarehouseRule::can('partners-list', 'index')): ?>
<div class="partners-list-index group-product-index">
    <nav id="w4" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <div id="w3-collapse" class="collapse navbar-collapse">
            <ul id="w5" class="navbar-nav w-100 nav">
                <li class="nav-item"><a class="nav-link" href="/warehouse/qty-type">Չափման միավոր</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/shipping-type">Տեղափոխության տեսակ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/status-list">Կարգավիճակներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/warehouse-types">Պահեստի տեսակներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/warehouse-groups">Վիրտուալ(տեսակներ)</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/suppliers-list">Մատակարարներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/partners-list">Գործընկերներ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/group-product">Ապրանքի խումբ</a></li>
                <li class="nav-item"><a class="nav-link" href="/warehouse/nomenclature-product">Ապրանքի Նոմենկլատուրա</a></li>
            </ul>
        </div>
    </nav>
    <h1 data-title="<?php echo $this->title[1]; ?>" style="padding: 20px;"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
    <?php if(\app\rbac\WarehouseRule::can('partners-list', 'create')): ?>
        <a style="float: right;margin-right: 10px;" href="<?= Url::to(['create']) ?>"  class="btn  btn-primary" >Ստեղծել</a>
    <?php endif; ?>
    </h1>
    <div style="padding:20px;" >
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('partners-list', 'update') ?
                            Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Թարմացնել'),
                                'class' => 'btn text-primary btn-sm mr-2'
                            ]) : '';
                    },
                    'delete' => function ($url, $model) {
                        return \app\rbac\WarehouseRule::can('partners-list', 'delete') ? Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                            'title' => Yii::t('app', 'Ջբջել'),
                            'class' => 'btn text-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                'method' => 'post',
                            ],
                        ]) : '';
                    }
                ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
    </div>
</div>

<?php endif; ?>