<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $actions app\modules\warehouse\models\Action */
/* @var $user app\models\User */


$this->title = Yii::t('app', 'Edit') . ": (" . $user->name . ")";
$this->params['breadcrumbs'][] = $this->title;
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<div class="user-edit-index">
    <input type="hidden" id="userID" value="<?php echo $user->id; ?>">
    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?> <a style="float: right" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary "  ><?php echo Yii::t('app', 'Create Warehouse'); ?></a></h1>

    <?php if ($actions):
        foreach ($actions as $action):
            echo sprintf(
                '<span class="action %s" data-id="%s">%s</span>',
                !$action->hasAccess($user->id) ? 'passive' : '',
                $action->id,
                $action->name
            );
        endforeach;
    else: ?>
        <span>No action found</span>
    <?php endif; ?>
</div>

<style>
    .action.passive {
        margin: 20px;
        padding: 20px;
        background-color: rgba(0, 85, 165, 0.5);
        color: white;
    }

    .action {
        margin: 20px;
        padding: 20px;
        background-color: rgba(0, 85, 165, 1);
        color: white;
        cursor: pointer;
    }
</style>

<script>
    window.onload = () => {
        $('.action').on('click', function() {
            let status = $(this).hasClass('passive') ? 'active' : '';
            let actionID = $(this).attr('data-id');
            let userID = $('#userID').val();
            $.post('change-permission', {
                status: status,
                actionID: actionID,
                userID: userID,
            }).done(() => {
                if (status) {
                    $(this).removeClass('passive');
                } else {
                    $(this).addClass('passive');
                }
            })
        })
    }
</script>