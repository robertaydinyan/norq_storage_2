<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\Helper;
use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use Yii;
use View;
use app\models\Notifications;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title>Նորք <?= Html::encode($this->title) ?></title>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=4c8b9626-0568-4074-9ac7-4c7cdd46f859&lang=ru_RU" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css"/>
    <link rel="icon" type="image/x-icon" href="/images/logo.svg"/>


    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

<?php if(!Yii::$app->user->isGuest) : ?>
    <?= $this->render('navbar') ?>
<?php endif;?>

<section id="page-content" class="d-flex">
    <?php if(!Yii::$app->user->isGuest) : ?>
        <div class="aside-box">
            <aside><?= $this->render('aside') ?></aside>
        </div>
    <?php endif;?>

    <div class="wrap">

        <!-- Navbar -->

        <?php
        //        if(Yii::$app->controller->module->id == 'fastnet'){
        Helper::constructMenu(Yii::$app->controller->module->id);
        //        }
        ?>
        <!-- .end Navbar -->

        <!-- Content -->
        <div class="wrap-page-columns">
            <?= $content ?>
        </div>
        <!-- .end Content -->

    </div>
</section>

<div class="current-url" data-url="<?= Yii::$app->request->url; ?>"></div>
<div class="current-module" data-module="<?= Helper::trimActionFromUrl(Url::current()); ?>"></div>

<?php
$user_id = Yii::$app->user->identity->id;
$notifiactionObj = new Notifications();
$notification_count = $notifiactionObj->getUserUnreadNotificationsCount($user_id);
$notifications = $notifiactionObj->getUserUnreadNotifications($user_id);


$string = '';
for($i = 0 ; $i<count($notifications);$i++){
    $string .= '<div class="dropdown-notifications-item-content " >
                   <a style="white-space: revert !important;" href="'.$notifications[$i]['notification_link'].'" notificationid="'.$notifications[$i]['id'].'" class="dropdown-item dropdown-notifications-item">
                    <div class="dropdown-notifications-item-content-text text-left" >'.$notifications[$i]['notification'].'</div>
                    <small class="dropdown-notifications-item-content-details text-left d-block">
                     '.date('d.m.Y g:i a',strtotime($notifications[$i]['creation_date'])).'
                    </small>
                    </a>';
    if($notifications[$i]['accept_url'] || $notifications[$i]['decline_url']){
        $string .= '<div class="control-buttons" style="margin-bottom:10px;">';
           if($notifications[$i]['accept_url']){
               $string .= '<a class="btn btn-success btn-sm" href="'.$notifications[$i]['accept_url'].'">Ընդունել</a>';
           }
            if($notifications[$i]['decline_url']){
                $string .= '<a class="btn btn-danger btn-sm" style="margin-left:10px;" href="'.$notifications[$i]['decline_url'].'">Մերժել</a>';
            }
        $string .= '</div>';
    }
    $string .= '</div>';
    $string .= '<hr style="margin:2px;">';
}

$this->registerJs("$('.fa-bell').closest('.dropdown-toggle').append('<small class=\"badge notifications-count badge-success\" style=\"top:-10px;font-size:50%;\">".$notification_count."</small>');
            $('.dropdown-notifications').on('click', 
                    function() { 
                        $('.dropdown-menu').html(`".$string."`);                      
                        $('.dropdown-notifications-item').on('click',
                                function() {
                                    var nid = parseInt(this.getAttribute('notificationid'));
                                    $.ajax({
                                        url: '/site/notifications',
                                        method:'POST',
                                        data:{'id':nid}
                                    });                            
                                }            
                        ); 
                    }
            );   
            setInterval(function() {
                $.ajax({
                    url: '/site/notifications-update',
                    method:'GET',
                    success:function(data){
                        $('.dropdown-menu').html(data);
                    }
                });                            
            },25000);   
        ");
?>
<div class=<?= $options['class'] ?> >
    <?php
    for($i = 0 ; $i < count($menu); $i++){
        if($notification_count!=''){
            echo "<span id='show_notifiactions' class='notification_exist ".$options['class']."-button'>";
        }
        else{
            echo "<span class='".$options['class']."-button'>";
        }
        echo '<i class="fa fa-bell" aria-hidden="true"></i>';
        if($notification_count>0){
            echo "<span class='".$options['class']."-count'>";
            echo $notification_count;
            echo '</span>';
        }
        echo '</span>';
    }
    echo '<div id="notifiactions_content">';
    echo '</div>';
    ?>
</div>
<style>
    .dropdown-menu{
        width: 300px !important;
        height: 300px !important;
        overflow: scroll !important;
    }
</style>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
