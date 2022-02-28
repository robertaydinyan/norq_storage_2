<div class="module-category-sidebar mt-3">
    <div class="module-component-wrapper">
        <div class="module-component-content-section">
            <div class="module-component-content-card-title">
                <span><?= $typeName ?></span>
            </div>

            <div class="module-component-content sidebar-module-component-content">
                <div class="module-component-content-card">

                    <!-- Module form -->
                    <?= $this->render('/'.Yii::$app->controller->id.'/'.$form, ['model' => $model]); ?>
                    <!-- .end Module form -->

                </div>
            </div>
        </div>
    </div>
</div>
