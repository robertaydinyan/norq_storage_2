<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\components\Helper;
use app\modules\warehouse\models\Favorite;
use app\modules\warehouse\models\UserHistory;
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
$history = UserHistory::find()->where(['user_id' => Yii::$app->user->id])->limit(5)->orderBy('time DESC')->all();
$favorites = Favorite::find()->where(['user_id' => Yii::$app->user->id])->all();
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
        <title>Նորք <?= Html::encode($this->title[0]) ?></title>
        <?php \app\rbac\WarehouseRule::savePage($this->title[1]); ?>
        <script src="https://api-maps.yandex.ru/2.1/?apikey=4c8b9626-0568-4074-9ac7-4c7cdd46f859&lang=ru_RU" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.2/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css"/>
        <link rel="stylesheet" href="https://unpkg.com/7.css">
        <link rel="icon" type="image/x-icon" href="/img/logo.png"/>


        <?php $this->head() ?>
    </head>
    <body>

    <?php $this->beginBody() ?>
    <?= $this->render('loading') ?>

    <?php if(!Yii::$app->user->isGuest) :?>
        <?= $this->render('navbar') ?>
    <?php endif;?>

    <section id="page-content" class="d-flex">
        <?php if(!Yii::$app->user->isGuest) : ?>
            <div class="aside-box d-none">
                <aside><?= $this->render('aside') ?></aside>
            </div>
        <?php endif;?>
        <div class="wrap">
            <?php if (Yii::$app->request->pathInfo != "site/error" && !Yii::$app->user->isGuest): ?>
                <div class="bookmarks d-flex row ">
                    
                    <div class="favorites col-12	col-sm-12	col-md-3 col-lg-4	col-xl-2 mb-3" >
                        <button class="accordion bg-white" style="background: #fff;"><?= Yii::t('app','Favorite') ?></button>
                        <div class="panel panel2">
                        <?php if (!empty($favorites)):
                            foreach ($favorites as $f):
                                $title = explode(":", $f->title);
                                $title = Yii::t('app', trim($title[0])) . ($title[1] ? (": " . $title[1]) : '');?>
                                <div class="favorite" data-url="<?php echo $f->link_no_lang ?>"
                                     <?php echo sprintf(
                                             "onclick='showPage(\"%s\", \"%s\", %s)'>",
                                            $f->link . (strpos($f->link, '?') ? '&' : '?') . 'lang=' . Yii::$app->language,
                                            $title,
                                            $f->id
                                    ) ?>
                                    <?php echo $title  ?>
                                    <i class="fa fa-times remove-favorite"></i>
                                </div>
                            <?php endforeach;
                        endif;?>
                        </div>
                    </div>
                    <div class="histories col-12	col-sm-12	col-md-3 col-lg-3	col-xl-2 mb-3" >
                        <button class="accordion bg-white" style="background: #fff"><?= Yii::t('app','History') ?> (5)</button>
                        <div class="panel panel2">
                        <?php if ($history):
                            foreach ($history as $h):
                                $title = explode(":", $h->title);
                                $title = Yii::t('app', trim($title[0])) . ($title[1] ? (": " . $title[1]) : '');?>
                                <div class="favorite"
                                    <?php echo sprintf(
                                        "onclick='showPage(\"%s\", \"%s\", %s)'>",
                                        $h->link . (strpos($h->link, '?') ? '&' : '?') . 'lang=' . Yii::$app->language,
                                        $title,
                                        $h->id
                                    ) ?>
                                    <?php echo $title; ?>
                                    <i class="fa fa-times remove-history-item" data-id="<?php echo $h->id; ?>"></i>
                                </div>
                            <?php endforeach;
                        endif;?>
                        </div>
                    </div>
                    <div class="col-12	col-sm-12	col-md-3 col-lg-3	col-xl-3 mb-3">
                        <form action="<?php echo URL::to('/warehouse/warehouse/home')?>" method="get" class="input-group rounded ">
                            <input name="search" value="<?php echo $_GET['search'];?>" type="search"
                                   class="form-control rounded" placeholder="<?php echo Yii::t('app', 'search'); ?>"
                                   aria-label="Search" style="height: 35px;border-radius: 0px !important;" aria-describedby="search-addon" />
                            <button id="search-addon" style="background: #0055a5!important;">
                                <i style="color:white;" class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
        <?php endif; ?>
         
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
                $string .= '<a class="btn btn-primary btn-sm" href="'.$notifications[$i]['accept_url'].'">Ընդունել</a>';
            }
            if($notifications[$i]['decline_url']){
                $string .= '<a class="btn btn-danger btn-sm" style="margin-left:10px;" href="'.$notifications[$i]['decline_url'].'">Մերժել</a>';
            }
            $string .= '</div>';
        }
        $string .= '</div>';
        $string .= '<hr style="margin:2px;">';
    }

    $this->registerJs("$('#sidenavAccordion .fa-bell').closest('.dropdown-toggle').append('<small class=\"badge notifications-count badge-primary\" style=\"top:-10px;font-size:50%;\">".$notification_count."</small>');
            $('.dropdown-notifications').on('click', 
                    function() {
                        $('.nots').html(`".$string."`);                      
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

    <?php echo $this->render('window-manager'); ?>

    <style>
        .window {
            width: 65%;
            height: 65%;
            box-shadow:none  !important;
        }
        .dropdown-menu{
            max-height:300px;
            width:auto !important;
            max-width:300px;
            min-width:10rem !important;
            height:auto !important;
            overflow: auto !important;
        }
        h1{
            font-size: 1.6rem !important;
        }
        h3{
            font-size: 1.3rem !important;
        }


        .favorite{
            border:1px solid #0055a5!important;
            padding:5px 20px;
            margin-top: 10px;
            cursor:pointer;
            display: flex;
            justify-content: space-between;
        }
        .window{
            z-index:1150 !important;
        }
        .zIndex{
            z-index:1200 !important;
        }
        .nozIndex {
            top: 10000px !important;
        }
        .favorite i{
            color:#0055a5!important;
            margin-left: 10px;
        }
        <?php if($_GET['show-header'] == "false"){ ?>
        *:not('button'){
            background:#f0f0f0 !important;

        }
        .wrap{
            padding: 0px !important;
            margin-bottom: 0px;
        }
        .group-product-index div{
            padding: 0px !important;
            padding-left: 10px !important;
        }
        .window-body{
            padding: 0px !important;
        }

         #page-content .favorite,.bookmarks,.navbar,.show-modal, .star{
            display:none !important;
        }
        h1{
            font-size: 14px !important;
        }
        <?php } ?>
    </style>

    <?php $this->endBody() ?>
    <div class="window" style="max-width: auto;display: none;position: fixed;">
        <div class="title-bar">
            <div class="title-bar-text">Another window with contents</div>
            <div class="title-bar-controls">
                <button aria-label="Minimize" onclick="minimize($(this))"></button>
                <button aria-label="Maximize" onclick="maximaize($(this))"></button>
                <button aria-label="Close" class="remove-window" ></button>
            </div>
        </div>
        <div class="window-body">

        </div>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>


<script>
    var acc = document.getElementsByClassName("accordion");
    var j;
    for (j = 0; j < acc.length; j++) {
        acc[j].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
