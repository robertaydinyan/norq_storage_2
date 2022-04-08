<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $isFavorite boolean */

$this->title = array(Yii::t('app', 'Currencies'), 'Currencies');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(\app\rbac\WarehouseRule::can('currency', 'index')): ?>
    <div class="currency-index">
        <?php echo $this->render('/menu_dirs', array(), true)?>

        <h1 style="padding: 20px;" data-title="<?php echo $this->title[1]; ?>" ><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>
        <div>
            <?php if(\app\rbac\WarehouseRule::can('currency', 'create')): ?>
                <?= Html::a(Yii::t('app', 'Create Currency'), ['create'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <button onclick="tableToExcel('tbl','test','currency.xls')" class="btn btn-primary  mr-2">Xls</button>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'id',
                'symbol',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>


    </div>
<?php endif; ?>