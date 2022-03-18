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
<div class="user-index">

    <h1 style="padding: 20px;" class="show-modal"><?= Html::encode($this->title) ?><span class="star" ><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span>
        <?php if(\app\rbac\WarehouseRule::can('users', 'create')): ?>
        <a style="float: right" href="<?= Url::to(['create', 'lang' => \Yii::$app->language]) ?>"  class="btn btn-primary "  ><?php echo Yii::t('app', 'Create user'); ?></a>
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
                            <a href="<?php echo URL::to(['users/edit', 'lang' => Yii::$app->language, 'id' => $user->id]); ?>"><i class="fas fa-pencil-alt"></i></a>
                        <?php endif; ?>
                        <?php if(\app\rbac\WarehouseRule::can('users', 'delete')): ?>
                            <a onclick="return AreYouSure();" href="<?php echo URL::to(['users/delete', 'lang' => Yii::$app->language, 'id' => $user->id]); ?>"><i class="fas fa-trash-alt" style="color: red;"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach;
            endif; ?>
        </table>
    </div>
</div>

<script>
    function AreYouSure() {
        return window.confirm('Are you absolutely sure ? You will lose all the information about this user with this action.');
    }
</script>