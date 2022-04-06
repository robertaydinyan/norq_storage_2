<?php
    namespace app\backend\components;
    use Yii;
    use View;
    use app\models\Notifications;

    $user_id = Yii::$app->user->identity->id;
    $notifiactionObj = new Notifications();
    $notification_count = $notifiactionObj->getUserUnreadNotificationsCount($user_id);
    $notifications = $notifiactionObj->getUserUnreadNotifications($user_id);
    if($notification_count==0){
        $notification_count = '';
    }
    $string = '<ul class="'.$options['class'].'-ul">';
    for($i = 0 ; $i<count($notifications);$i++){
        $string .= '<li notificationid="'.$notifications[$i]['id'].'" class="'.$options['class'].'-li">';
        $string .= '<span class="'.$options['class'].'-li_header" >#'.$notifications[$i]['id'].' '.$notifications[$i]['creation_date'].'</span><br>';
        $string .= '<span class="'.$options['class'].'-li_text" >'.$notifications[$i]['notification'].'</span><br>';
        $string .= '<span class="'.$options['class'].'-li_link" ><a href="'.$notifications[$i]['notification_link'].'">'.$notifications[$i]['notification_link'].'</a></span><br>';
        $string .= '</li>';
    }
    $string .= '</ul>';


    $this->registerJs("
            $('#show_notifiactions').on('click', 
                    function() { 
                        if(document.getElementById('notifiactions_content').classList.contains('opened-bar')){
                            document.getElementById('notifiactions_content').classList.remove('opened-bar');
                        }
                        else{
                            document.getElementById('notifiactions_content').classList.add('opened-bar');
                            document.getElementById('notifiactions_content').innerHTML = '".$string."';                      
                        }    
                        $('.notification-bar-li').on('click',
                                function() {
                                    var nid = parseInt(this.getAttribute('notificationid'));
                                    $.ajax({
                                        url: '../notifications/notifications',
                                        method:'POST',
                                        data:{'updateStatus':'true','notificationid':nid}
                                    });                            
                                }            
                        ); 
                    }
            );      
            $(document).click(function(e) {
                if ( $(e.target).closest('#show_notifiactions').length === 0 && $(e.target).closest('.notification-bar-li').length === 0 ) {
                    if(document.getElementById('notifiactions_content').classList.contains('opened-bar')){
                        document.getElementById('notifiactions_content').classList.remove('opened-bar');
                    }
                }
            });  
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
<?php

    $this->registerCss('
        
        .'.$options['class'].'{
            position:fixed;
            top:7px;
            right:5px;            
            width:50px;
            height:50px;
            background-color:inherit;
            color:#fff;
            font-size:20px;
            z-index:10000;
        }
        .'.$options['class'].'-count{
            position: absolute;
            top: 6px;
            right: 18px;
            width: 14px;
            height: 14px;
            font-size: 10px;
            color: #BB5B20;
            font-weight: 600;
            border-radius: 100%;
            text-align: center;
            background-color: #FFF;
        }
        .'.$options['class'].'-ul{
            padding-left:0px;
            margin:0px;           
            list-style:none;
            font-size:14px;
            color:#000;    
            height:100%;        
        }
        .notification_exist:hover{
            cursor:pointer;
        }
        #notifiactions_content{
            display:none;
            position:absolute;
            background-color:#fff;
            top:45px;
            right:0px;
            width:300px;
            max-height:800px;
            box-shadow: 0 0 10px 0 #ccc;   
            z-index:10000; 
            overflow:auto;
        }
        .opened-bar{
            display:block!important;
        }
        .notification-bar-li_header{
            font-size:11px;
            color:#5C9592;
        }
        .notification-bar-li{
            padding:10px;
            border-bottom:1px solid #ccc;
        }
        .notification-bar-li:hover{
            cursor:pointer;
            background-color:#E0EDEC;
        }
        .notification-bar-li_text{
            font-size:13px;
            word-break: break-word;
        }
        .notification-bar-li_link{
            font-size:13px;
            word-break: break-all;
        }
        
    ');
?>
