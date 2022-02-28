<?php

use app\components\Helper;

?>
<div class="sk-page-grid-sm-12 sk-page-grid-md-2">
    <div class="module-category-sidebar">
        <div class="module-component-wrapper">
            <div class="module-component-header justify-content-between">
                <a href="#" class="nav-link active"><?= Yii::t('app', 'Категория'); ?></a>
                <a href="#" class="nav-link"><?= Yii::t('app', 'Размещения'); ?></a>
                <button type="button" class="btn">
                    <i class="far fa-chevron-double-left"></i>
                </button>
            </div>
            <div class="module-component-actions">
                <div class="module-component-actions-manage">
                    <div class="row no-gutters">
                        <div class="col-sm-6">
                            <button type="button" class="btn">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            <button type="button" class="btn">
                                <i class="fas fa-minus-circle"></i>
                            </button>
                            <button type="button" class="btn">
                                <i class="fas fa-repeat-alt"></i>
                            </button>
                            <button type="button" class="btn">
                                <i class="fas fa-pencil"></i>
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <a href="#" class="text-underline"><?= Yii::t('app', 'Ավելացնել') ?></a>
                            <a href="#" class="text-underline"><?= Yii::t('app', 'Ջնջել') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="module-component-content">
                <div class="module-component-content-card">
                    <div class="module-component-category-tree">
                        <ul id="category-tree">
                            <?php if (!empty($categories)) : ?>
                                <?php Helper::drawCategoryTree($categories); ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>