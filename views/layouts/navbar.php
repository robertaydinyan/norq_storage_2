<?php

use app\components\Url;

use app\components\Helper;

$flags = array(
    'ru-RU' => 'ru',
    'en-US' => 'en',
    'hy' => 'hy',
);
$lang = Yii::$app->request->get('lang');
$flag = $flags[$lang] ?: 'hy';

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
    <a class="navbar-brand" href="/warehouse/warehouse/home?lang=<?php echo \Yii::$app->language; ?>" style="color:#fff!important"><img src="/img/logo.png" style="width:35px;height: 35px;" class="mr-3">Warehouse</a>
    <?php
    //        if(Yii::$app->controller->module->id == 'fastnet'){
    Helper::constructMenu(Yii::$app->controller->module->id);
    //        }
    ?>

    <!--<form class="form-inline mr-auto d-none d-md-block w-100">
        <div class="form-group">
            <div class="c-floating-label m-0">
                <input class="form-control w-100 c-input" type="search" placeholder=" " aria-label="Search">
                <label>Поиск . . .</label>
            </div>
        </div>
    </form>-->

    <ul class="navbar-nav align-items-center ml-auto">
        <li class="nav-item dropdown no-caret mr-3 d-none d-md-inline">
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
        <li class="nav-item dropdown no-caret mr-3 d-md-none">
           <!-- <a class="btn btn-icon btn-transparent-dark dropdown-toggle p-0 rounded-circle" id="searchDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></a>-->
            <!-- Dropdown - Search-->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--fade-in-up" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100">
                    <div class="input-group input-group-joined input-group-solid">
                        <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                       <!-- <div class="input-group-append">
                            <div class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></div>
                        </div>-->
                    </div>
                </form>
            </div>
        </li>
<!--        <li class="nav-item dropdown no-caret mr-3 dropdown-notifications">-->
<!--            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownAlerts" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
<!--                <i class="fas fa-comment-alt"></i>-->
<!--            </a>-->
<!--            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownAlerts">-->
<!--                <h6 class="dropdown-header dropdown-notifications-header">-->
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell mr-2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>-->
<!--                    Alerts Center-->
<!--                </h6>-->
<!--                <a class="dropdown-item dropdown-notifications-item" href="#!">-->
<!--                    <div class="dropdown-notifications-item-icon bg-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg></div>-->
<!--                    <div class="dropdown-notifications-item-content">-->
<!--                        <div class="dropdown-notifications-item-content-details">December 29, 2019</div>-->
<!--                        <div class="dropdown-notifications-item-content-text">This is an alert message. It's nothing serious, but it requires your attention.</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="dropdown-item dropdown-notifications-item" href="#!">-->
<!--                    <div class="dropdown-notifications-item-icon bg-info"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart"><line x1="12" y1="20" x2="12" y2="10"></line><line x1="18" y1="20" x2="18" y2="4"></line><line x1="6" y1="20" x2="6" y2="16"></line></svg></div>-->
<!--                    <div class="dropdown-notifications-item-content">-->
<!--                        <div class="dropdown-notifications-item-content-details">December 22, 2019</div>-->
<!--                        <div class="dropdown-notifications-item-content-text">A new monthly report is ready. Click here to view!</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="dropdown-item dropdown-notifications-item" href="#!">-->
<!--                    <div class="dropdown-notifications-item-icon bg-danger"><svg class="svg-inline--fa fa-exclamation-triangle fa-w-18" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-triangle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg><!-- <i class="fas fa-exclamation-triangle"></i> </div>-->
<!--                    <div class="dropdown-notifications-item-content">-->
<!--                        <div class="dropdown-notifications-item-content-details">December 8, 2019</div>-->
<!--                        <div class="dropdown-notifications-item-content-text">Critical system failure, systems shutting down.</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="dropdown-item dropdown-notifications-item" href="#!">-->
<!--                    <div class="dropdown-notifications-item-icon bg-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>-->
<!--                    <div class="dropdown-notifications-item-content">-->
<!--                        <div class="dropdown-notifications-item-content-details">December 2, 2019</div>-->
<!--                        <div class="dropdown-notifications-item-content-text">New user request. Woody has requested access to the organization.</div>-->
<!--                    </div>-->
<!--                </a>-->
<!--                <a class="dropdown-item dropdown-notifications-footer" href="#!">View All Alerts</a>-->
<!--            </div>-->
<!--        </li>-->
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
                    Message Center
                </h6>
                <a class="dropdown-item dropdown-notifications-item" href="#!">
<!--                    <img class="dropdown-notifications-item-img" src="https://source.unsplash.com/vTL_qy03D1I/60x60">-->
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Emily Fowler · 58m</div>
                    </div>
                </a>
                <a class="dropdown-item dropdown-notifications-item" href="#!">
<!--                    <img class="dropdown-notifications-item-img" src="https://source.unsplash.com/4ytMf8MgJlY/60x60">-->
                    <div class="dropdown-notifications-item-content">
                        <div class="dropdown-notifications-item-content-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
                        <div class="dropdown-notifications-item-content-details">Diane Chambers · 2d</div>
                    </div>
                </a>
                <a class="dropdown-item dropdown-notifications-footer" href="#!">Read All Messages</a>
            </div>
        </li>

     

        <!-- Если пользователь гость, показыаем ссылку "Вход", если он авторизовался "Выход" -->
        <?php if (!Yii::$app->user->isGuest) : ?>
            <li class="nav-item dropdown no-caret mr-2 dropdown-user">
                <a class="btn btn-icon btn-transparent-dark dropdown-toggle p-0 rounded-circle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-fluid" src="<?= Yii::getAlias('@web/img/user/user.jpg') ?>"></a>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                    <h6 class="dropdown-header d-flex align-items-center">
                        <img class="dropdown-user-img" src="<?= Yii::getAlias('@web/img/user/user.jpg') ?>">
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
<div style="background: red">
    <?php
    //        if(Yii::$app->controller->module->id == 'fastnet'){
    Helper::constructMenu(Yii::$app->controller->module->id);
    //        }
    ?>
</div>

<style>
    .btn-success{
        background:#474747 !important;
         border:2px solid #474747 !important;
    }
    }
</style>


