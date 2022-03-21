<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $actions app\modules\warehouse\models\Action */
/* @var $user app\models\User */


$this->title = array(Yii::t('app', 'Edit') . ": (" . $user->name . ")",'Edit');
$this->params['breadcrumbs'][] = $this->title[0];
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<div class="user-edit-index">
    <input type="hidden" id="userID" value="<?php echo $user->id; ?>">
    <h1 style="padding: 20px;" class="show-modal" data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[1]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span> </h1>

        <?php if (isset($controller_names)):
            foreach ($controller_names as $cname):
                echo '<button class="accordion"><h5 style="margin-bottom: 20px;">' . Yii::t('app', $cname->controller_name) . '</h5></button>
                      <div class="row panel" style="margin-bottom: 20px;padding-top: 20px;"><div class="d-flex flex-wrap pt-2 ">';
                foreach($cname->getByControllerName() as $action):
                    echo sprintf(
                            '<div class="col-2" style="margin-bottom: 48px;"><span class="action %s" data-id="%s">%s</span></div>',
                            !$action->hasAccess($user->id) ? 'passive' : '',
                            $action->id,
                            $action->action_name
                        );
                endforeach;
                echo '</div></div>';
            endforeach;
        else: ?>
            <span>No action found</span>
        <?php endif; ?>

    </div>
</div>

<style>
    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }




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
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>