<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\warehouse\models\QtyType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qty-type-form">
    <?php $form = ActiveForm::begin(); ?>
    <input type="radio" class="form-control">
     <div style="padding:20px;">
        <div>
            <?php foreach ($tableTreePartners as $tableTreePartner) : ?>
                <?php if($tableTreePartner['id'] != 7){
                    continue;
                } ?>
                    <ul style="display: block;" class="file-tree">
                        <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/payments-log/tree_table.php', [
                            'tableTreePartner' => $tableTreePartner,
                        ]); ?>
                    </ul>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-4 hide">
        <?= $form->field($model, 'invoice')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-lg-4">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <div style="padding-left: 15px;">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php if(isset($type) && $type == 'create'): ?>
            <?= Html::button(Yii::t('app', 'Save 2'), ['class' => 'btn btn-primary saveForm', 'onClick' => 'SaveForm($(this))'])  ?>
        <?php endif; ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<style>
    input[type=radio] {
        appearance: auto;
        opacity: inherit;
    }
</style>