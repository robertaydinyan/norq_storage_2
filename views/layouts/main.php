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
            <div class="aside-box d-none">
                <aside><?= $this->render('aside') ?></aside>
            </div>
        <?php endif;?>
        <div class="wrap">
            <div class="bookmarks d-flex">
                <?php if (Yii::$app->request->pathInfo != "site/error"): ?>
                    <div class="favorites" style="margin-left: 40px;">
                        <?php if ($favorites):
                            foreach ($favorites as $f):
                                $title = explode(":", $f->title); ?>
                                <div class="favorite" data-url="<?php echo $f->link_no_lang ?>"
                                     onclick='showPage("<?php echo $f->link . (strpos($f->link, '?') ? '&' : '?') . 'lang=' . Yii::$app->language ?>")'>
                                    <?php echo Yii::t('app', trim($title[0])) . ($title[1] ? (": " . $title[1]) : ''); ?>
                                    <i class="fa fa-times remove-favorite"></i>
                                </div>
                            <?php endforeach;
                        endif;?>
                    </div>
                    <div class="histories" style="margin-left: 40px;">
                        <?php if ($history):
                            foreach ($history as $h):
                                $title = explode(":", $h->title); ?>
                                <div class="favorite"
                                     onclick="showPage('<?php echo $h->link . (strpos($h->link, '?') ? '%' : '?') . 'lang=' . Yii::$app->language ?>')">
                                    <?php echo Yii::t('app', trim($title[0])) . ($title[1] ? (": " . $title[1]) : ''); ?>
                                    <i class="fa fa-times remove-history-item" data-id="<?php echo $h->id; ?>"></i>
                                </div>
                            <?php endforeach;
                        endif;?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Navbar -->

            <!--  --><?php
            /*        //        if(Yii::$app->controller->module->id == 'fastnet'){
                    Helper::constructMenu(Yii::$app->controller->module->id);
                    //        }
                    */?>
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
            setInterval(function() {
                $.ajax({
                    url: '/site/notifications-update',
                    method:'GET',
                    success:function(data){
                        $('.nots').html(data);
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
            max-height:300px;
            width:auto !important;
            max-width:300px;
            min-width:10rem !important;
            height:auto !important;
            overflow: scroll !important;
        }
        h1{
            font-size: 1.6rem !important;
        }
        h3{
            font-size: 1.3rem !important;
        }


        .favorite{
            border:1px solid #1b55e2!important;
            padding:5px 20px;
            display:inline-block;
            cursor:pointer;
        }
        .window{
            z-index:1150 !important;
        }
        .zIndex{
            z-index:1200 !important;
        }
        .favorite i{
            color:#1b55e2!important;
        }
        <?php if(isset($_GET['show-header'])){ ?>
        *:not('button'){
            background:#f0f0f0 !important;
        }
        .navbar {
            display:none;
        }
        #page-content .favorite{
            display:none !important;
        }
        <?php } ?>
    </style>
    <?php if(!isset($_GET['show-header'])){ ?>
        <script>
            function maximaize(el_){
                $(el_).closest('.window').css({'width':'100%','height':'100%','top':'0px','left':'0px'});
                $(el_).closest('.window').find('iframe').css({'width':'100%','min-height':'100vh'});
            }

            function showPage(url, header = true){
                $('.window').on('click',function(){
                    $('.window').removeClass('zIndex');
                    $(this).addClass('zIndex');
                });

                var html_ = '<iframe src="' + url + (header ? '&show-header=false' : '?show-header=false') + '" style="width:90vw;min-height:50vh;border:0px;"></iframe>';
                var window_ = $('.window').first().clone().css({top:'20%',left:'5vw',position:'absolute'});
                window_.find('.window-body').html(html_);
                $('body').append(window_);
                $( function() {
                    $( ".window" ).draggable();
                } );
                // $('.modal-content-custom *').replaceWith(html_);
                // $('.modal-content-custom').show().animate({left: '10%'}, {duration: 300});
                // $('.modal-content-custom .close').click(function(){
                //     $('.modal-content-custom').animate({left: '110%'}, {duration: 300});
                //     $('.modal-content-custom .page1').remove();
                // });
            }
        </script>
    <?php } ?>
    <?php $this->endBody() ?>
    <div class="window" style="max-width: auto">
        <div class="title-bar">
            <div class="title-bar-text">Another window with contents</div>
            <div class="title-bar-controls">
                <button aria-label="Maximize" onclick="maximaize($(this))"></button>
                <button aria-label="Close" onclick="$(this).closest('.window').remove()" ></button>
            </div>
        </div>
        <div class="window-body">

        </div>
    </div>
    </body>
    </html>
<?php $this->endPage() ?>