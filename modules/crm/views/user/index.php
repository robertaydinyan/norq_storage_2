<?php

use app\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Աշխատակիցներ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="card card-body border-0 shadow rounded mt-3">
        <div class="d-flex align-items-center justify-content-between">
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Ավելացնել Աշխատակից', ['create'], ['class' => 'btn btn-success']) ?>
        </div>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'username',
                'name',
                'last_name',
                'email',
                [
                    'attribute' => 'status',
                    'filter' => [
                        User::STATUS_ACTIVE => 'Ակտիվ',
                        User::STATUS_DELETED => 'Պասիվ',
                    ],
                    'value' => function($model) {
                        return $model->getStatus()[$model->status];
                    }
                ],
                [
                    'attribute' => 'role',
                    'filter' => [
                        User::ROLE_ADMIN => 'Ադմին',
                        User::ROLE_MANAGER => 'Մենեջեր',
                        User::ROLE_OPERATOR => 'Օպերատոր',
                        User::ROLE_TERMINAL => 'Տերմինալ',
                        User::ROLE_USER => 'Օգտատեր',
                    ],
                    'value' => function($model) {
                        return $model->getRole()[$model->role];
                    }
                ],
                //'password_reset_token',
                //'email:email',
                //'status',
                //'role',
                //'created_at',
                //'updated_at',
                //'last_name',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Հղում',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return
                                Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                                    'title' => Yii::t('app', 'Թարմացնել'),
                                    'class' => 'btn text-primary btn-sm mr-2'
                                ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<i class="fas fa-trash-alt"></i>', $url, [
                                'title' => Yii::t('app', 'Ջբջել'),
                                'class' => 'btn text-danger btn-sm',
                                'data' => [
                                    'confirm' => 'Are you absolutely sure ? You will lose all the information about this user with this action.',
                                    'method' => 'post',
                                ],
                            ]);
                        }

                    ]
                ],
            ],
        ]); ?>

    </div>
</div>
