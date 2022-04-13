<?php

use app\components\Url;

use app\components\Helper;
use app\modules\warehouse\models\SiteSettings;

$flags = array(
    'ru-RU' => 'ru',
    'en-US' => 'en',
    'hy' => 'hy',
);
$lang = Yii::$app->request->get('lang');
$flag = $flags[$lang] ?: 'hy';
$s = SiteSettings::find()->where(['name' => 'page-status'])->one()->value;

?>


<div class="modal-content-custom">
    <div class="close"><i class="fa fa-close"></i></div>
</div>
<div  id="page-modal" style="display: none;">
    <div class="page1">

    </div>
</div>
<div  id="FilterModal" class="modal" tabindex="-1" role="dialog">
</div>
<?php //echo $this->render('/modal/modal-table'); ?>
<input type="hidden" id="user-id" value="<?php echo YII::$app->user->id; ?>">
<input type="hidden" id="lang" value="<?php echo explode('-', \Yii::$app->language)[0] ?: 'hy'; ?>">
<input type="hidden" id="user-link" value="<?php echo URL::current(); ?>">
<input type="hidden" id="user-link-no-lang" value="<?php echo \app\rbac\WarehouseRule::removeLangFromLink(URL::current()); ?>">
<nav class="topnav navbar navbar-expand shadow navbar-light" id="sidenavAccordion" style=" background:#0055a5!important;">
    <span style="font-size:30px;cursor:pointer;color: #fff" onclick="openNav()" class="px-3 menu-media">&#9776; </span>
    <a class="navbar-brand" href="/warehouse/warehouse/home?lang=<?php echo \Yii::$app->language; ?>" style="color:#fff!important;padding-left: 20px;"><img src="/img/logo.png" style="width:35px;height: 35px;" class="mr-3">Warehouse</a>
    <div class="main-header2 ">
    <?php
    //        if(Yii::$app->controller->module->id == 'fastnet'){
    Helper::constructMenu(Yii::$app->controller->module->id);
    //        }
    ?>
    </div>


    <ul class="navbar-nav align-items-center ml-auto">
        <li class="nav-item dropdown no-caret mr-3  d-md-inline">
            <a class="nav-link dropdown-toggle timer" id="navbarDropdownDocs" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div id="txt" style="color: #fff;"></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right py-0 mr-sm-n15 mr-lg-0 o-hidden animated--fade-in-up" aria-labelledby="navbarDropdownDocs">
                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro" target="_blank">
                    <div class="icon-stack bg-primary-soft text-primary mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    </div>
                    <div>
                        <div class="small text-gray-500">Documentation</div>
                        Usage instructions and reference
                    </div>
                </a>
                <div class="dropdown-divider m-0"></div>
                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/components" target="_blank">
                    <div class="icon-stack bg-primary-soft text-primary mr-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-code"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg></div>
                    <div>
                        <div class="small text-gray-500">Components</div>
                        Code snippets and reference
                    </div>
                </a>
                <div class="dropdown-divider m-0"></div>
                <a class="dropdown-item py-3" href="https://docs.startbootstrap.com/sb-admin-pro/changelog" target="_blank">
                    <div class="icon-stack bg-primary-soft text-primary mr-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></div>
                    <div>
                        <div class="small text-gray-500">Changelog</div>
                        Updates and changes
                    </div>
                </a>
            </div>
        </li>
        <?php if(Yii::$app->user->identity->role == "admin"):?>
            <a href="javascript:void(0);" class="change-site-status" style="color: white; font-size: 20px;" data-status="0" title="<?php echo Yii::t('app', ($s ? 'Stop website' : 'Start website')); ?>">
                <i class="<?php echo $s ? 'fa fa-ban' : 'fas fa-car'?>"></i></a>
            </a>
        <?php endif; ?>
        <li class="nav-item dropdown no-caret mr-3 d-md-none">
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100">
                    <div class="input-group input-group-joined input-group-solid">
                        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    </div>
                </form>
            </div>
        </li>

        <li class="nav-item dropdown no-caret">
            <div class="dropdown">
                <button class="g-btn flag shadow-none" type="button dropdown-toggle" id="dropdownLangButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/img/icons/flags/<?php echo $flag;?>.png" class="g-lang-flag g-lang-flag-show " alt="flag" width="20">
                </button>

                <ul class="dropdown-menu lang-dropdown-menu dropdown-menu-right g-navbar-buttons-drop" aria-labelledby="dropdownLangButton" x-placement="bottom-end" style="position: absolute; transform: translate3d(-126px, 38px, 0px); top: 0px; left: 0px; will-change: transform;">
                    <li>
                        <a class="dropdown-item" rel="alternate" hreflang="en" href="<?php echo Url::current(['lang' => 'en-US']) ?>">
                            <img src="/img/icons/flags/en.png" class="g-lang-flag" alt="flag" width="20"> English
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" rel="alternate" hreflang="ru" href="<?php echo Url::current(['lang' => 'ru-RU']) ?>">
                            <img src="/img/icons/flags/ru.png" class="g-lang-flag" alt="flag" width="20"> русский
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" rel="alternate" hreflang="hy" href="<?php echo Url::current(['lang' => 'hy']) ?>">
                            <img src="/img/icons/flags/hy.png" class="g-lang-flag" alt="flag" width="20"> Հայերեն
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item dropdown no-caret dropdown-notifications">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle p-0 rounded-circle" id="navbarDropdownMessages" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell" style="color:#fff"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownMessages">
                <h6 class="dropdown-header dropdown-notifications-header">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail mr-2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                </h6>
                <div class="nots">

                </div>
                <a class="dropdown-item dropdown-notifications-footer" href="/notifications">Read All</a>
            </div>
        </li>

        <?php if (!Yii::$app->user->isGuest) : ?>
            <li class="nav-item dropdown no-caret mr-2 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle p-0 rounded-circle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-fluid" src="<?= Yii::getAlias('@web/img/user/user.png') ?>"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <div class="dropdown-user-details">
                            <div class="dropdown-user-details-name"><?= \Yii::$app->user->identity->username ?></div>
                            <div class="dropdown-user-details-email"><?= \Yii::$app->user->identity->email ?></div>
                        </div>
                    </h6>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#!">
                        <div class="dropdown-item-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></div>
                        Account
                    </a>
                    <a class="dropdown-item" href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" data-method="post">
                        <div class="dropdown-item-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </div>
                        <?= Yii::t('app', 'Выход') ?>
                    </a>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</nav>


<div id="mySidenav" class="sidenav mt-5">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="font-size: 30px">&times;</a>
    <?php
       Helper::constructMenu(Yii::$app->controller->module->id);
    ?>
</div>



