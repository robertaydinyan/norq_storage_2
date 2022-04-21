<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Вход в систему');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .login-input {
        height: 37px!important;
    }
    .login-btn,.login-btn:hover,.login-btn:after,.login-btn:focus {
        background: #0055a5!important;
    }
</style>
<div class="site-login h-100">
    <div class="container h-100">
        <div class="row justify-content-md-center align-items-center h-100">
            <div class="card-wrapper">
                <div class="card fat">
                    <div class="card-body">
                        <h4 class="card-title mx-0 border-0"><?= Html::encode($this->title) ?></h4>

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'fieldConfig' => [
                                'template' => "{label} {input} {error}",
                                'labelOptions' => ['class' => 'control-label'],
                            ],
                        ]); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true,'class' => 'login-input form-control'])->label(Yii::t('app', 'Имя пользователя')) ?>

                        <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'class' => 'login-input form-control'])->label(Yii::t('app', 'Пароль')) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox([
                            'template' => "{input} {label} {error}",
                        ])->label(Yii::t('app', 'Запомни меня')) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Login', ['class' => ' btn-block c-btn login-btn', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>