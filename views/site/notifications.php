<?php
use app\models\Notifications;

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
echo $string;
?>
<script>
    $('.notifications-count').text("<?php echo $notification_count;?>");
</script>
