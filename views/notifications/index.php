<?php
/* @var $notifications app\models\Notifications */
/* @var $nc integer */
/* @var $page integer */
/* @var $count_per_page integer */
/* @var $isFavorite boolean */

use app\components\Url;
use yii\helpers\Html;

$this->title = array(Yii::t('app', 'Notifications'), 'Notifications');
$this->params['breadcrumbs'][] = $this->title[0];
$tp = ceil($nc / $count_per_page);
?>

<div class="notification-index">
    <div class="d-flex flex-wrap justify-content-between align-items-center">
        <h1 data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
    </div>
    <?php if (isset($notifications)):
        foreach ($notifications as $n):
                $not = sprintf('
                    <div class="dropdown-notifications-item-content " >
                        <a style="white-space: revert !important;" href="%s" notificationid="%s" class="dropdown-item dropdown-notifications-item">
                            <div class="dropdown-notifications-item-content-text text-left" >%s</div>
                            <small class="dropdown-notifications-item-content-details text-left d-block">%s</small>
                        </a>',
                    $n->notification_link,
                    $n->id,
                    $n->notification,
                    date('d.m.Y g:i a',strtotime($n['creation_date']))
                );
                if ($n->accept_url || $n->decline_url) {
                    $not .= sprintf('
                        <div class="control-buttons" style="margin-bottom:10px;">
                            %s
                            %s
                        </div>',
                        $n->accept_url ? '<a class="btn btn-primary btn-sm" href="' . $n->accept_url . '">Ընդունել</a>' : '',
                        $n->decline_url ? '<a class="btn btn-primary btn-sm" href="' . $n->decline_url . '">Մերժել</a>' : ''
                    );
                }
                $not .= '</div>
                <hr style="margin:2px;">';
                echo $not
            ?>

        <?php endforeach;
    endif;
    ?>
    <br>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="<?php echo Url::current(['page' => $page - 1]) ?>">&laquo;</a>
            <a href="<?php echo Url::current(['page' => 1]) ?>">1</a>
        <?php endif; ?>
        <?php if ($page > 3): ?>
            <a href="#">...</a>
        <?php endif; ?>

        <?php if ($page > 2): ?>
            <a href="<?php echo Url::current(['page' => $page - 1]) ?>"><?php echo $page - 1; ?></a>
        <?php endif; ?>
        <a class="active" href="#"><?php echo $page ?></a>
        <?php if ($tp - $page > 2): ?>
            <a href="<?php echo Url::current(['page' => $page + 1]) ?>"><?php echo $page + 1; ?></a>
        <?php endif; ?>
        <?php if ($tp - $page > 1): ?>
            <a href="#">...</a>
        <?php endif; ?>
        <?php if ($tp > $page): ?>
            <a href="<?php echo Url::current(['page' => $tp]) ?>"><?php echo $tp ?></a>
            <a href="<?php echo Url::current(['page' => $page + 1]) ?>">&raquo;</a>
        <?php endif; ?>
    </div>
</div>