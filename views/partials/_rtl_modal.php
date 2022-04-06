<?php

use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

?>
<!-- Modal -->
<div class="modal sk-rtl-modal fade" id="sidebarModal" tabindex="-1" role="dialog" aria-labelledby="sidebarModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fal fa-times"></i>
                </button>
                <h4 class="modal-title" id="myModalLabel2"><?= Yii::t('app', 'Просмотр документа') ?></h4>
            </div>

            <div class="modal-body">

                <?php
                /*
                NavBar::begin([ // отрываем виджет
                    'brandLabel' => false, // название организации
                    'brandUrl' => \Yii::$app->homeUrl, // ссылка на главную страницу сайта
                    'options' => [
                        'class' => 'main-header navbar navbar-expand bg-white navbar-light shadow-sm', // стили главной панели
                    ],
                    'renderInnerContainer' => false,
                ]);

                echo Nav::widget([
                    'options' => ['class' => 'navbar-nav w-100'], // стили ul
                    'items' => [
                        ['label' => Yii::t('app', 'Загрузить файл'), 'url' => ['/'.Yii::$app->controller->id.'/']],
                        ['label' => Yii::t('app', 'Пример загрузочного файла'), 'url' => ['/'.Yii::$app->controller->id.'/']],
                    ],
                ]);

                NavBar::end(); // закрываем виджет
                */
                ?>

                <!-- Modules detail sidebar -->
                <div class="form-content">

                </div>
                <!-- .end Modules detail sidebar -->

            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->