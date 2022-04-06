<?php
namespace app\backend\components;
use yii\base\Widget;
use yii\helpers\Html;
class NotificationBar extends Widget {
  public $menu;
  public $options;
  public $_menuObject;
  public $_options;
  public function init() {
   $this->_menuObject = $this->menu;
   $this->_options = $this->options;
   parent::init();
   // if ($this->menu === null) {
   // $this->menu = 'Welcome Guest';
   // } else {
   // $this->menu = 'Welcome ' . $this->menu;
   // }
 }
 public function run(){
     return $this->render('notificationBar', ['menu' => $this->_menuObject,'options' => $this->_options]);
 }
}
?>
