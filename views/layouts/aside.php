<?php

use app\components\Helper;

?>
<nav class="nav flex-column">
    <span class="aside-toggle btn">
        <i class="far fa-bars"></i>
    </span>
    <span class="aside-admin-name"></span>

    <?php if (!empty(Helper::asideMenu())) : ?>
        <?php foreach (Helper::asideMenu() as $aside) : ?>

            <div class="links">
                <a class="nav-link <?= Helper::isModuleUrl($aside['url'], Yii::$app->controller->module->id, Yii::$app->controller->id) === true ? 'active' : '' ?>" href="<?= \Yii::t('app', $aside['url']) ?>">
                    <span class="sidebar-icon <?= $aside['icon'] ?>"></span>
                    <span class="sidebar-link"><?= Yii::t('app', $aside['title']); ?></span>
                </a>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
</nav>