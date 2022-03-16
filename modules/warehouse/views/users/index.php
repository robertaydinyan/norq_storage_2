<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
$lang = explode('-', \Yii::$app->language)[0] ?: 'en';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--<style>-->
<!--    .modal-content-custom{-->
<!--        display: none;-->
<!--        width: 90%;-->
<!--        height: 100%;-->
<!--        position: fixed;-->
<!--        top: 0px;-->
<!--        left: 110%;-->
<!--        background: white !important;-->
<!--        z-index: 100000;-->
<!--        box-shadow: 2px 2px 2px 2px lightgray;-->
<!--        /*   transition-duration: 500ms;*/-->
<!---->
<!--    }-->
<!--    .modal-content-custom .page1{-->
<!--        width: 100% !important;-->
<!--        padding: 30px;-->
<!--        max-height: 100vh;-->
<!--        overflow: auto;-->
<!--    }-->
<!--    .modal-content-custom .close {-->
<!--        position: absolute;-->
<!--        top: 10%;-->
<!--        left: -60px;-->
<!--        min-width: 60px;-->
<!--        border-radius: 20px 0px 0px 20px;-->
<!--        color: white;-->
<!--        background: #2fc6f6;-->
<!--        opacity:1!important;-->
<!--        cursor: pointer;-->
<!--        padding: 5px 5px 5px 15px;-->
<!--    }-->
<!--</style>-->
<?php if(\app\rbac\WarehouseRule::can('users', 'index')): ?>
<div class="user-index">

    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?>
        <?php if(\app\rbac\WarehouseRule::can('users', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary "  ><?php echo Yii::t('app', 'Create Warehouse'); ?></a>
        <?php endif; ?>
    </h1>

    <div style="padding:20px;" class="table">
        <table class="kv-grid-table table table-hover  kv-table-wrap">
            <tr>
                <th>id</th>
                <th>name</th>
                <th>last name</th>
                <th>email</th>
                <th>actions</th>
            </tr>
            <?php if (isset($users)):
                foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user->id; ?></td>
                    <td><?php echo $user->name; ?></td>
                    <td><?php echo $user->last_name; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td>
                        <?php if(\app\rbac\WarehouseRule::can('users', 'edit')): ?>
                        <a href="users/edit?lang=<?php echo Yii::$app->language; ?>&id=<?php echo $user->id; ?>"><i class="fas fa-pencil-alt"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach;
            endif; ?>
        </table>
    </div>
</div>
<?php endif; ?>


<!--<script type="text/javascript">-->
<!--    $('.show-modal').click(function(){-->
<!--        var href = $(this).attr('data-modal');-->
<!--        var html_ = $('#page-modal').html();-->
<!---->
<!--        $('.modal-content-custom').append(html_);-->
<!--        $('.modal-content-custom').show().animate({left: '10%'}, {duration: 600});-->
<!--        $('.modal-content-custom .close').click(function(){-->
<!--            $('.modal-content-custom').animate({left: '110%'}, {duration: 600});-->
<!--            $('.modal-content-custom .page1').remove();-->
<!--        });-->
<!--    });-->
<!---->
<!--</script>-->
