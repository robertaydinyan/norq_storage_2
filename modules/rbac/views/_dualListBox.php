<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $assignUrl array */
/* @var $removeUrl array */
/* @var $opts string */

$this->registerJs("var _opts = {$opts};", View::POS_BEGIN);
?>
<div class="row">
    <div class="col-lg-5">
        <input class="form-control search" data-target="available"
               placeholder="<?php echo Yii::t('app', 'Search for available'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="available"></select>
    </div>
    <div class="col-lg-2">
        <div class="move-buttons">
            <br><br>
            <?php echo Html::a('&gt;&gt;', $assignUrl, [
                'class' => 'btn btn-primary btn-assign',
                'data-target' => 'available',
                'title' => Yii::t('app', 'Assign'),
            ]); ?>
            <br/><br/>
            <?php echo Html::a('&lt;&lt;', $removeUrl, [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => Yii::t('app', 'Remove'),
            ]); ?>
        </div>
    </div>
    <div class="col-lg-5">
        <input class="form-control search" data-target="assigned"
               placeholder="<?php echo Yii::t('app', 'Search for assigned'); ?>">
        <br/>
        <select multiple size="20" class="form-control list" data-target="assigned"></select>
    </div>
</div>