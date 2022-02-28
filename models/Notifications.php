<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;



class Notifications extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 's_notification';
    }

    public function getUserUnreadNotifications($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.*');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->andWhere(['s_notification.status'=>0]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            return  $command->queryAll();
        } else {
            return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }
    public function getUserReadNotifications($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.*');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->andWhere(['s_notification.status'=>1]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            return  $command->queryAll();
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }


    public function getUserUnreadNotificationsCount($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.status');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->andWhere(['s_notification.status'=>0]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            $dataReader=$command->query();
            return  $dataReader->rowCount;
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }
    public function getUserReadNotificationsCount($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.status');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->andWhere(['s_notification.status'=>1]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            $dataReader=$command->query();
            return  $dataReader->rowCount;
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }

    public function getUserAllNotifications($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.*');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            return  $command->queryAll();
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }
    public function getUserAllNotificationsCount($user_id){
        if($user_id){
            $notification = Notifications::find();
            $notification->select('s_notification.status');
            $notification->andWhere(['s_notification.user_id'=>$user_id]);
            $notification->orderBy(['s_notification.id'=>SORT_DESC]);
            $command = $notification->createCommand();
            $dataReader=$command->query();
            return  $dataReader->rowCount;
        }
        else{
          return json_encode(array('status'=>false,'message'=>'Wrong user id type'));
        }
    }



    public function getAllUnreadNotifications(){
        $notification = Notifications::find();
        $notification->select('s_notification.*');
        $notification->andWhere(['s_notification.status'=>0]);
        $command = $notification->createCommand();
        return  $command->queryAll();
    }
    public function getAllReadNotifications(){
        $notification = Notifications::find();
        $notification->select('s_notification.*');
        $notification->andWhere(['s_notification.status'=>1]);
        $notification->orderBy(['s_notification.id'=>SORT_DESC]);
        $command = $notification->createCommand();
        return  $command->queryAll();
    }




    public function getAllUnreadNotificationsCount(){
        $notification = Notifications::find();
        $notification->select('s_notification.status');
        $notification->andWhere(['s_notification.status'=>0]);
        $notification->orderBy(['s_notification.id'=>SORT_DESC]);
        $command = $notification->createCommand();
        $dataReader=$command->query();
        return  $dataReader->rowCount;
    }
    public function getAllReadNotificationsCount(){
        $notification = Notifications::find();
        $notification->select('s_notification.status');
        $notification->andWhere(['s_notification.status'=>1]);
        $notification->orderBy(['s_notification.id'=>SORT_DESC]);
        $command = $notification->createCommand();
        $dataReader=$command->query();
        return  $dataReader->rowCount;
    }
    public function getAllNotifications(){
        $notification = Notifications::find();
        $notification->select('s_notification.*');
        $notification->orderBy(['s_notification.id'=>SORT_DESC]);
        $command = $notification->createCommand();
        return  $command->queryAll();
    }

    public function getNotificationStatus($notification_id){
        if($notification_id){
            $notification = Notifications::find();
            $notification->select('s_notification.*');
            $notification->andWhere(['s_notification.id'=>$notification_id]);
            $command = $notification->createCommand();
            return  $command->queryAll();
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong notification id type'));
        }
    }

    public function setNotification($user_id,$notification,$notification_link,$accept_url = null,$decline_url = null){
        if($notification!='' && $user_id){
            $notificationObj = new Notifications;
            $notificationObj->user_id = $user_id;
            $notificationObj->notification = $notification;
            $notificationObj->notification_link = $notification_link;
            $notificationObj->accept_url = $accept_url;
            $notificationObj->decline_url = $decline_url;
            $notificationObj->creation_date = Date('Y-m-d h:i:s');
            $notificationObj->insert();
            return json_encode(array('status'=>true,'message'=>'Inserted successfully'));
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Notifiaction is empty or user id is NaN'));
        }
    }

    public function updateNotification($notification_id,$notification){
        if($notification_id){
            $notificationObj = (new Notifications)->find()->andWhere(['id'=>$notification_id])->all();
            $count = 0 ;
            foreach ($notificationObj as $model) {
                $count++;
                $model->notificationObj = $notification;
                $model->update(false);               
            }
            if($count>0){
                return json_encode(array('status'=>true,'message'=>'Updated Notification successfully'));
            }
            else{
                return json_encode(array('status'=>false,'message'=>'Wrong notification id parametr'));
            }
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong notification id type'));
        }
    }

    public function updateNotificationLink($notification_id,$notification_link){
        if($notification_id){
            $notification = (new Notifications)->find()->andWhere(['id'=>$notification_id])->all();
            $count = 0 ;
            foreach ($notification as $model) {
                $count++;
                $model->notification_link = $notification_link;
                $model->update(false);               
            }
            if($count>0){
                return json_encode(array('status'=>true,'message'=>'Updated Notification Link successfully'));
            }
            else{
                return json_encode(array('status'=>false,'message'=>'Wrong notification id parametr'));
            }
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong notification id type'));
        }
    }


    public function updateNotificationStatus($notification_id){        
        if($notification_id){             
            $count = 0 ;
            $notification = (new Notifications)->find()->andWhere(['id'=>$notification_id])->all();    
            foreach ($notification as $model) {                
                $count++;
                $model->status = 1;
                $model->update(false);               
            }
            if($count>0){
                return json_encode(array('status'=>true,'message'=>'Updated Status successfully'));
            }
            else{
                return json_encode(array('status'=>false,'message'=>'Wrong notification id parametr'));
            }
        }
        else{
            return json_encode(array('status'=>false,'message'=>'Wrong notification id type'));
        }
    }
}
?>