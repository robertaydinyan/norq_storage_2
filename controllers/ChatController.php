<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Chat;
class ChatController extends Controller
{
    public function actionChat(){
                date_default_timezone_set('Asia/Yerevan');
                if (Yii::$app->request->post()) {
                        if (Yii::$app->request->isAjax) {
                                if(isset($_POST['workerid'])){
                                        $workerOBJ = getAllWorkerDetailArray();
                                        $returnString = '<ul id="chatUserUl">';
                                        foreach($workerOBJ as $worker){
                                            if($worker['user_id'] != $_POST['workerid']){
                                               $lastmsgOBJ = getLastMsg($_POST['workerid'],$worker['user_id']);
                                                $lastmsg = '';
                                                $msgto = '';
                                                $msgfrom = '';
                                                $mfstatus = '';
                                                $mtstatus = '';
                                                $count = 0;
                                                $unread = '';
                                                foreach ($lastmsgOBJ as $lmsg){
                                                    $lastmsg = $lmsg['msg'];
                                                    $msgto = $lmsg['msg_to'];
                                                    $msgfrom = $lmsg['msg_from'];
                                                    $mtstatus = $lmsg['mtstatus'];                                               
                                                    if($msgfrom==$worker['user_id'] && $msgto==$_POST['workerid']){ 
                                                                                                        
                                                        if($mtstatus==0){
                                                            $unread =' Չկարդացած';
                                                        }
                                                        else{
                                                            $unread ='';
                                                        }
                                                     
                                                    }
                                                    else{
                                                        $unread = '';
                                                    }
                                                  
                                                }
                                                if($worker['user_sex'] == 'իգական'){
                                                    if($msgfrom==$worker['user_id'] && $msgto==$_POST['workerid'] || $msgfrom==$_POST['workerid'] && $msgto==$worker['user_id']){
                                                        if($unread == ' Չկարդացած'){
                                                            $returnString .= '<li style="background:#f1efef" class="chatUsers " messageWith="' .$worker['user_id'].'"><div class="chat_user_img_girl"></div><div class="chat_image_header"><div class="chatUsers_child">'.$worker['user_name'].' '.$worker['user_surname'].' <span style="font-size:13px;color:red;font-weight:400;">'.$unread.'</span></div><div class="chatUsers_child-msg">gfjdj'.$lastmsg.'</div></div></li>';
                                                        }else {
                                                            $returnString .= '<li class="chatUsers " messageWith="' .$worker['user_id'].'"><div class="chat_user_img_girl"></div><div class="chat_image_header"><div class="chatUsers_child">'.$worker['user_name'].' '.$worker['user_surname'].' <span style="font-size:13px;color:red;font-weight:400;">'.$unread.'</span></div><div class="chatUsers_child-msg">gfjdj'.$lastmsg.'</div></div></li>';

                                                        }
                                                    }
                                                    else{
                                                        $returnString .= '<li class="chatUsers " messageWith="'.$worker['user_id'].'"><div class="chat_user_img_girl"></div><div class="chat_image_header"><div class="chatUsers_child">'.$worker['user_name'].' '.$worker['user_surname'].'</div><div class="chatUsers_child-msg"></div></div></li>';
                                                    }
                                                } else {
                                                    if($msgfrom==$worker['user_id'] && $msgto==$_POST['workerid'] || $msgfrom==$_POST['workerid'] && $msgto==$worker['user_id']){
                                                        if($unread == ' Չկարդացած') {
                                                            $returnString .= '<li style="background:#f1efef"  class="chatUsers " messageWith="' . $worker['user_id'] . '"><div class="chat_user_img_boy"></div><div class="chat_image_header"><div class="chatUsers_child">' . $worker['user_name'] . ' ' . $worker['user_surname'] . ' <span style="font-size:13px;color:red;font-weight:400;">' . $unread . '</span></div><div class="chatUsers_child-msg">' . $lastmsg . '</div></div></li>';
                                                        }else {
                                                            $returnString .= '<li  class="chatUsers " messageWith="' . $worker['user_id'] . '"><div class="chat_user_img_boy"></div><div class="chat_image_header"><div class="chatUsers_child">' . $worker['user_name'] . ' ' . $worker['user_surname'] . ' <span style="font-size:13px;color:red;font-weight:400;">' . $unread . '</span></div><div class="chatUsers_child-msg">' . $lastmsg . '</div></div></li>';

                                                        }
                                                    }
                                                    else{
                                                        $returnString .= '<li class="chatUsers " messageWith="'.$worker['user_id'].'"><div class="chat_user_img_boy"></div><div class="chat_image_header"><div class="chatUsers_child">'.$worker['user_name'].' '.$worker['user_surname'].'</div><div class="chatUsers_child-msg"></div></div></li>';
                                                    }
                                                }
                                            }
                                        }


                                        $returnString .= '</ul>';

                                        return $returnString;
                                }
                                if(isset($_POST['getChat']) && isset($_POST['messageFrom']) && isset($_POST['messageTo'])){
                                    $chatOBJ = getMessagesDetailArray($_POST['messageFrom'],$_POST['messageTo']);

                                   
                                    updateChatStatus($_POST['messageFrom'],$_POST['messageTo']);
                                    $returnString = '<ul id="chatUserUl">';
                                    foreach($chatOBJ as $chat){
                                        if($chat['message_from']== $_POST['messageFrom']){

                                            $currentUserOBJ = getWorkerDetailArray($_POST['messageFrom']);
                                            foreach($currentUserOBJ as $cu){
                                                if($cu['user_sex'] == 'իգական'){
                                                    $returnString .= '<li class="msgLi leftChat"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_girl"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                                } else {
                                                    $returnString .= '<li class="msgLi leftChat"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_boy"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                                }

                                            }                               
                                            $returnString .= '<span style="font-weight: 400;font-size:11px">'.$chat['creation_date'].'</span></div></span>';
                                            $returnString .= '<span  class="chat-message">'.$chat['message'].'</span></li>';

                                        }
                                        else{
                                            $currentUserOBJ = getWorkerDetailArray($_POST['messageTo']);
                                            foreach($currentUserOBJ as $cu){
                                                if($cu['user_sex'] == 'իգական'){
                                                    $returnString .= '<li class=" msgLi rightChat"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_girl"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                                } else {
                                                    $returnString .= '<li class="msgLi rightChat"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_boy"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                                }
                                            }
                                            $returnString .= '<span style="font-weight: 400;font-size:11px">'.$chat['creation_date'].'</span></div></span>';
                                            $returnString .= '<span class="chat-message">'.$chat['message'].'</span></li>';
                                        }

                                    }
                                    $returnString .= '</ul>';

                                    return $returnString;
                                }
                                if(isset($_POST['sendChat']) && isset($_POST['messageFrom']) && isset($_POST['messageTo']) && isset($_POST['message'])){

                                    $chat = new Chat();
                                    $returnString = '';
                                    $chat->sendMessage($_POST['messageFrom'],$_POST['messageTo'],$_POST['message']);
                                    if($chat){            
                                            $currentUserOBJ = getWorkerDetailArray($_POST['messageFrom']);
                                        foreach($currentUserOBJ as $cu){
                                            if($cu['user_sex'] == 'իգական'){
                                                $returnString .= '<li class="msgLi leftChat" id="lastChild"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_girl"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                            } else {
                                                $returnString .= '<li class="msgLi leftChat" id="lastChild"><span style="font-weight:bold;font-size:14px;"><div class="chat_user_img_boy"></div><div>'.$cu['user_name'].' '.$cu['user_surname'];
                                            }
                                        }
                                                 $returnString .= '<span style="font-weight: 400;font-size:11px">'.Date('Y-m-d h:i:s').'</span></div></span>';
                                                $returnString .= '<span  class="chat-message">'.$_POST['message'].'</span></li>';
                                    }
                                    return $returnString;                                        
                                }
                        }
                }
    }
}