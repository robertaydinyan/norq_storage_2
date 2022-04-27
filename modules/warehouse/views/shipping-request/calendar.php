<?php


use app\modules\warehouse\models\Currency;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\warehouse\models\ShippingRequestSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = array(Yii::t('app', 'Polls'), 'Polls');
$this->params['breadcrumbs'][] = $this->title[0];
$this->registerJsFile('@web/js/modules/crm/contact.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/css/modules/warehouse/custom-tree-view.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/js/modules/warehouse/custom-tree.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/calendar/fullcalendar/packages/core/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/calendar/fullcalendar/packages/interaction/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/calendar/fullcalendar/packages/daygrid/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/calendar/fullcalendar/packages/timegrid/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/js/plugins/calendar/fullcalendar/packages/list/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerCssFile('@web/js/plugins/calendar/fullcalendar/packages/core/main.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerCssFile('@web/js/plugins/calendar/fullcalendar/packages/daygrid/main.css', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$table_all_columns = array();
?>
<?php if (\app\rbac\WarehouseRule::can('shipping-request', 'index')): ?>
    <div class="shipping-request-index group-product-index">
        <nav id="w5" class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <div id="w5-collapse" class="collapse navbar-collapse">
                <ul id="w5" class="navbar-nav w-100 nav">
                    <?php $uri = explode('?', $_SERVER['REQUEST_URI']); ?>
                    <li class="nav-item "><a class="nav-link <?php if (!isset($_GET['type'])) {
                            echo 'active';
                        } ?>"
                                             href="<?php echo $uri[0] ?>"><?php echo Yii::t('app', 'All'); ?></a>
                    </li>
                    <?php foreach ($shipping_types as $shp_type => $shp_type_val) { ?>
                        <li class="nav-item "><a
                                    class="nav-link <?php if (isset($_GET['type']) && ($_GET['type'] == $shp_type_val->id)) {
                                        echo 'active';
                                    } ?>"
                                    href="?type=<?php echo $shp_type_val->id; ?>"><?php echo $shp_type_val->name; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
        <div class="d-flex flex-wrap justify-content-between mt-3">
            <h1  data-title="<?php echo $this->title[1]; ?>"><?= Html::encode($this->title[0]) ?><span
                        class="star"><i class="fa <?php echo $isFavorite ? 'fa-star' : 'fa-star-o' ?> ml-4"></i></span></h1>
            <div style="padding-left: 20px" class="d-flex align-items-start pt-2">
                <a  style="float: right" href="<?= Url::to(['documents']) ?>"
                       class="btn btn-primary mr-2"><?php echo Yii::t('app', 'Documents'); ?></a>
                <?php if (\app\rbac\WarehouseRule::can('shipping-request', 'create')): ?>

                    <a style="float: right" href="<?= Url::to(['create']) ?>"
                       class="btn btn-primary mr-2"><?php echo Yii::t('app', 'Create a query'); ?></a>
                <?php endif; ?>
                <!-- <button onclick="tableToExcel('tbl','test','warehouse.xls')" class="btn btn-primary float-right mr-2">Xls</button> -->
               <!--  <button class="btn btn-primary mr-2 position-relative" style="float: right">
                    <div id="list1" class="dropdown-check-list" tabindex="100" >
                        <span class="anchor"><i class="fa fa-list" style="width: -webkit-fill-available;"></i></span>
                        <ul class="items">
                            <?php if ($columns):
                                foreach ($columns as $i => $k): ?>
                                    <li><input type="checkbox" class="hide-row" data-queue="<?php echo $i; ?>"  checked/><?php echo Yii::t('app', $k->row_name_normal) ?> </li>
                                <?php endforeach;
                            endif; ?>
                        </ul>
                    </div>
                </button> -->
                <!-- <button class="btn btn-primary mr-2 filter" style="float: right" data-type="<?php echo $_GET['type']; ?>"
                        data-model="ShippingRequest"><i class="fa fa-wrench "></i></button> -->
                </a>
            </div>

        </div>
        <div style="padding:20px;">
















            <form class="row" action="" method="get">
                <?php if (isset($_GET['type'])) { ?>
                    <input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
                <?php } ?>
                <div class="col-12	col-sm-12	col-md-12 col-lg-12	col-xl-5" style="margin-bottom: 10px;">
                    <div class="row">
                        <div class="col-sm-4">
                            <select name="provider_warehouse_id" class="form-control btn-primary">
                                <option value=""><?php echo Yii::t('app', 'Provider warehouse'); ?></option>
                                <?php if (!empty($warehouses)) {
                                    foreach ($warehouses as $warehouse => $wh) {
                                        if (@$_GET['provider_warehouse_id'] == $warehouse) {
                                            $act = 'selected';
                                        } else {
                                            $act = '';
                                        }
                                        echo '<option value="' . $warehouse . '" ' . $act . '>' . $wh . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select name="supplier_warehouse_id" class="form-control btn-primary">
                                <option value=""><?php echo Yii::t('app', 'Supplier warehouse'); ?></option>
                                <?php if (!empty($warehouses)) {
                                    foreach ($warehouses as $warehouse => $wh) {
                                        if (@$_GET['supplier_warehouse_id'] == $warehouse) {
                                            $act = 'selected';
                                        } else {
                                            $act = '';
                                        }
                                        echo '<option value="' . $warehouse . '" ' . $act . '>' . $wh . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select name="user_id" class="form-control btn-primary">
                                <option value=""><?php echo Yii::t('app', 'Responsible'); ?></option>
                                <?php if (!empty($users)) {
                                    foreach ($users as $user => $usval) {
                                        if (@$_GET['user_id'] == $user) {
                                            $act = 'selected';
                                        } else {
                                            $act = '';
                                        }
                                        echo '<option value="' . $user . '" ' . $act . '>' . $usval . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                </div>
           
                <div class="col-10	col-sm-10	col-md-4 col-lg-4	col-xl-2">
                    <button type="button" class="btn btn-primary form-control" data-toggle="modal"
                            data-target="#suppliersModal"><?php echo Yii::t('app', 'Suppliers') ?></button>
                    <div class="modal fade" id="suppliersModal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php $id = @intval($_GET['ShippingRequest']['supplier_id']); ?>
                                    <ul class="file-tree"
                                        style="border:1px solid #dee2e6;padding-left: 35px;padding-top: 5px;margin-top:0px;">
                                        <?php foreach ($suppliers as $tableTreePartner) : ?>
                                            <li class="file-tree-folder">
                         <span data-name="<?= $tableTreePartner['name'] ?>"
                               class="parent-block"><?= $tableTreePartner['name'] ?>
                        </span>
                                                <ul style="display: block;">
                                                    <?= \Yii::$app->view->renderFile('@app/modules/warehouse/views/suppliers-list/tree_form_sup_table.php', [
                                                        'tableTreePartner' => $tableTreePartner,
                                                        'checked' => $id,
                                                    ]); ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2	col-sm-2	col-md-2 col-lg-2	col-xl-1">
                    <button type="submit" class="btn btn-primary b-none">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>



































            <br>
            <?php if (!isset($_GET['type']) || $_GET['type'] == 7) {
                $table_all_columns = [
                    'id' => 'id',
                    'shippingType' => [
                        'attribute' => 'shippingType',
                        'label' => Yii::t('app', 'Type of transportation'),
                        'value' => function ($model) {
                            return $model->shippingtype->name;
                        }
                    ],
                    'providerWarehouse' => [
                        'attribute' => 'providerWarehouse',
                        'label' => Yii::t('app', 'Transfer warehouse'),
                        'value' => function ($model) {
                            return $model->provider->name;
                        }
                    ],
                    'supplierWarehouse' => [
                        'attribute' => 'supplierWarehouse',
                        'label' => Yii::t('app', 'Supplier warehouse'),
                        'value' => function ($model) {
                            return $model->supplier->name;
                        }
                    ],
                    'supplier' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Responsible'),
                        'value' => function ($model) {
                            return $model->user->name . ' ' . $model->user->last_name;
                        }
                    ],
                    'totalAmount' => [
                        'label' => Yii::t('app', 'Total amount'),
                        'value' => function ($model) {
                            $s = explode(' ', $model->totalsum);
                            return number_format($s[0], '0', '.', ',') . ' ' . $s[1];
                        },
                        'contentOptions' => function($model) {
                            $s = explode(' ', $model->totalsum)[0];

                            return [
                                'title' => Currency::fromDram($s)
                            ];
                        },

                    ],
                    'created' => [
                        'label' => Yii::t('app', 'Created'),
                        'value' => function ($model) {
                            return date('d.m.Y', strtotime($model->created_at));
                        }
                    ],
                    'status' => [
                        'label' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            return $model->status->name;
                        }
                    ],
                    'document_type' => [
                        'label' => Yii::t('app', 'Document type'),
                        'value' => function ($model) {
                            return Yii::t('app', $model->document_type == 1 ? 'Basic' : ($model->document_type == 2 ? 'Commission' : ''));
                        }
                    ]
                ];
                $actions = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Action'),
                    'template' => '{view}{update}{accept}{decline}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('shipping-request', 'view') ?
                                Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . Yii::$app->language, [
                                    'title' => Yii::t('app', 'View'),
                                    'class' => 'btn text-primary  btn-sm mr-2'
                                ]) : '';
                        },
                        'update' => function ($url, $model) {
                            if ($model->status != 3) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'update') ?
                                    Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Change'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else {
                                return '';
                            }
                        },
                        'accept' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept-admin') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/warehouse/shipping-request/accept-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                        'decline' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn text-danger  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline-admin') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/warehouse/shipping-request/decline-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn text-danger  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                    ]
                ];
            } else if ($_GET['type'] == 6 || $_GET['type'] == 2 || $_GET['type'] == 5) {
                $table_all_columns = [
                    'id' => 'id',
                    'shippingType' => [
                        'attribute' => 'shippingType',
                        'label' => Yii::t('app', 'Type of transportation'),
                        'value' => function ($model) {
                            return $model->shippingtype->name;
                        }
                    ],
                    'supplierWarehouse' => [
                        'attribute' => 'supplierWarehouse',
                        'label' => Yii::t('app', 'Supplier warehouse'),
                        'value' => function ($model) {
                            return $model->supplier->name;
                        }
                    ],
                    'responsible' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Responsible'),
                        'value' => function ($model) {
                            return $model->user->name . ' ' . $model->user->last_name;
                        }
                    ],
                    'supplier' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Supplier'),
                        'value' => function ($model) {
                            return $model->supplierp->name;;
                        }
                    ],
                    'totalAmount' => [
                        'label' => Yii::t('app', 'Total amount'),
                        'value' => function ($model) {
                            return number_format($model->totalsum, '0', '.', ',') . ' դր․';
                        }
                    ],
                    'invoice' => [
                        'attribute' => 'invoice',
                        'label' => 'Invoice',
                        'value' => function ($model) {
                            return $model->invoice;
                        }
                    ],
                    'status' => [
                        'label' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            return $model->status->name;
                        }
                    ],
                    'created' => [
                        'label' => Yii::t('app', 'Created'),
                        'value' => function ($model) {
                            return date('d.m.Y', strtotime($model->created_at));
                        }
                    ]
                ];
                $actions = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Reference'),
                    'template' => '{view}{update}{accept}{decline}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('shipping-request', 'view') ?
                                Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . Yii::$app->language, [
                                    'title' => Yii::t('app', 'View'),
                                    'class' => 'btn text-primary  btn-sm mr-2'
                                ]) : '';
                        },
                        'update' => function ($url, $model) {
                            if ($model->status != 3) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'update') ?
                                    Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Change'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else {
                                return '';
                            }
                        },
                        'accept' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                        'decline' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn text-danger  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                    ],
                ];
            } else if ($_GET['type'] == 8 || $_GET['type'] == 10) {
                $table_all_columns = [
                    'id' => 'id',
                    'shippingType' => [
                        'attribute' => 'shippingType',
                        'label' => Yii::t('app', 'Type of transportation'),
                        'value' => function ($model) {
                            return $model->shippingtype->name;
                        }
                    ],
                    'supplierWarehouse' => [
                        'attribute' => 'supplierWarehouse',
                        'label' => Yii::t('app', 'Supplier warehouse'),
                        'value' => function ($model) {
                            return $model->provider->name;
                        }
                    ],
                    'supplier' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Responsible'),
                        'value' => function ($model) {
                            return $model->user->name . ' ' . $model->user->last_name;
                        }
                    ],
                    'status' => [
                        'label' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            return $model->status->name;
                        }
                    ],
                    'totalAmount' => [
                        'label' => Yii::t('app', 'Total amount'),
                        'value' => function ($model) {
                            return number_format($model->totalsum, '0', '.', ',') . ' դր․';
                        }
                    ],
                    'created' => [
                        'label' => Yii::t('app', 'Created'),
                        'value' => function ($model) {
                            return date('d.m.Y', strtotime($model->created_at));
                        }
                    ],
                ];
                $actions = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Reference'),
                    'template' => '{view}{update}{accept}{decline}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('shipping-request', 'view') ?
                                Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . Yii::$app->language, [
                                    'title' => Yii::t('app', 'View'),
                                    'class' => 'btn text-primary  btn-sm mr-2'
                                ]) : '';
                        },
                        'update' => function ($url, $model) {
                            if ($model->status != 3) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'update') ?
                                    Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Change'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else {
                                return '';
                            }
                        },
                        'accept' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept-admin') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/warehouse/shipping-request/accept-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Accept'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                        'decline' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn btn-danger  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline-admin') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/warehouse/shipping-request/decline-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn btn-danger  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                    ]
                ];
            } else if ($_GET['type'] == 9) {
                $table_all_columns = [
                    'id' => 'id',
                    'shippingType' => [
                        'attribute' => 'shippingType',
                        'label' => Yii::t('app', 'Type of transportation'),
                        'value' => function ($model) {
                            return $model->shippingtype->name;
                        }
                    ],
                    'supplierWarehouse' => [
                        'attribute' => 'supplierWarehouse',
                        'label' => Yii::t('app', 'Delivery warehouse'),
                        'value' => function ($model) {
                            return $model->provider->name;
                        }
                    ],
                    'responsible' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Responsible'),
                        'value' => function ($model) {
                            return $model->user->name . ' ' . $model->user->last_name;
                        }
                    ],
                    'supplier' => [
                        'attribute' => 'supplier',
                        'label' => Yii::t('app', 'Partner'),
                        'value' => function ($model) {
                            if ($model->is_phys == 0) {
                                return $model->supplierp->name;
                            } else {
                                return $model->supplierp->name . ' ' . $model->supplierp->surname;
                            }
                        }
                    ],
                    'status' => [
                        'label' => Yii::t('app', 'Status'),
                        'value' => function ($model) {
                            return $model->status->name;
                        }
                    ],
                    'totalAmount' => [
                        'label' => Yii::t('app', 'Total amount'),
                        'value' => function ($model) {
                            return number_format($model->totalsumsale, '0', '.', ',') . ' դր․';
                        }
                    ],
                    'created' => [
                        'label' => Yii::t('app', 'Created'),
                        'value' => function ($model) {
                            return date('d.m.Y', strtotime($model->created_at));
                        }
                    ],
                ];
                $actions = [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => Yii::t('app', 'Reference'),
                    'template' => '{view}{update}{accept}{decline}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return \app\rbac\WarehouseRule::can('shipping-request', 'view') ?
                                Html::a('<i class="fas fa-eye"></i>', $url . '&lang=' . Yii::$app->language, [
                                    'title' => Yii::t('app', 'View'),
                                    'class' => 'btn text-primary  btn-sm mr-2'
                                ]) : '';
                        },
                        'update' => function ($url, $model) {
                            if ($model->status != 3) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'update') ?
                                    Html::a('<i class="fas fa-pencil-alt"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Change'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else {
                                return '';
                            }
                        },
                        'accept' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'accept-admin') ?
                                    Html::a('<i class="fa fa-check" aria-hidden="true"></i>', '/warehouse/shipping-request/accept-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Confirm'),
                                        'class' => 'btn text-primary  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                        'decline' => function ($url, $model) {
                            if ($model->status == 2) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', $url . '&lang=' . Yii::$app->language, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn text-danger  btn-sm mr-2'
                                    ]) : '';
                            } else if ($model->status == 5 && \Yii::$app->user->can('admin')) {
                                return \app\rbac\WarehouseRule::can('shipping-request', 'decline-admin') ?
                                    Html::a('<i class="fa fa-times" aria-hidden="true"></i>', '/warehouse/shipping-request/decline-admin?id=' . $model->id, [
                                        'title' => Yii::t('app', 'Reject'),
                                        'class' => 'btn text-danger  btn-sm mr-2'
                                    ]) : '';
                            }
                        },
                    ]
                ];
            }


            $table_columns = [];
            if (isset($columns)) {
                foreach ($columns as $column) {
                    if ($table_all_columns[$column->row_name]) {
                        array_push($table_columns, $table_all_columns[$column->row_name]);
                    }
                }
            }
            if (count($table_columns) == 0) {
                $table_columns = $table_all_columns;
            }
            if ($actions)
                array_push($table_columns, $actions);
            ?>





<div id='calendar-container'>
    <div id='calendar'></div>
  </div>
    

        </div>
        <div class="modal fade" id="viewInfo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="mod-content"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>


<?php endif; ?>


<?php 


$js_events = [];
$color = [];
$i = 0;
$colors = ['#49851b','#a410e8','#b64280','#c3a115','#ab4a16','#0cff09','#f562e0','#6d1d5d','#3fe03d','#67610a','#2ffd32','#52775d'];
foreach($dataProvider as $value){
    if ($i>0) {
       if(isset($color[$value->shipping_type])){
        continue;
       }
    }
    
$color[$value->shipping_type] = $colors[$i];
$i++;
}

foreach($dataProvider as $value){
    
    $js_events[] = ['title'=>$value->shippingtype->name.' '.'#'.$value->id,'start'=>$value->created_at,'url'=>'/warehouse/shipping-request/view?id='.$value->id,'color'=>$color[$value->shipping_type]];
    
}

?>

    <script>



const months = {
  January: '01',
  February: '02',
  March: '03',
  April: '04',
  May: '05',
  June: '06',
  July: '07',
  August: '08',
  September: '09',
  October: '10',
  November: '11',
  December: '12',
}   


window.onload = function() {

    var $x = <?php echo json_encode($js_events); ?>;
    var today = new Date();
    var calendarEl = document.getElementById('calendar');    
    var new_var_cal = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      height: 'parent',
      header: {
        left: 'prev,next',
        center: 'title',
        right: ''
      },
      defaultView: 'dayGridMonth',
      defaultDate: today,
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events

      events: $x,
      textColor : '#FFFFFF',
      
      eventClick: function(info) {
    info.jsEvent.preventDefault(); // don't let the browser navigate
    if (info.event.url) {       
      showPage(info.event.url,info.event._def.title);
       }
    },
    
    });

    new_var_cal.render();



$(document).on('click','.fc-next-button', function() {
                
                var current_month = $('.fc-center').find('h2').text();     
                current_month = current_month.split(' ');                             
                var month_ajax = months[current_month[0]];
                var events;
                var pathname = window.location.href.split('/')[5].split('calendar')[1];
                
                        
                 
                  $.ajax({
                            url: "/warehouse/shipping-request/calendar-ajax"+pathname+"",
                                type: "post",
                                data: {month_ajax: month_ajax},
                                dataType: "json",
                                success: function (response) {
                                     if($.isEmptyObject(response)){
                                        events = '';
                                    }else{
                                        events = response;
                                    }
                                        

                                        new_var_cal.destroy();
                                        var today = new Date();                                        
                                        day =  today.getDate(),
                                        year = today.getFullYear();                                                                               
                                        var calendarEl = document.getElementById('calendar');    
                                        new_var_cal = new FullCalendar.Calendar(calendarEl, {
                                          plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                                          height: 'parent',
                                          header: {
                                            left: 'prev,next',
                                            center: 'title',
                                            right: ''
                                          },
                                          defaultView: 'dayGridMonth',
                                          defaultDate:  year+'-'+month_ajax+'-'+day,
                                          navLinks: true, // can click day/week names to navigate views
                                          editable: true,
                                          eventLimit: true, // allow "more" link when too many events
                                          events: events,
                                          
                                           eventClick: function(info) {
                                            info.jsEvent.preventDefault(); // don't let the browser navigate
                                            if (info.event.url) {
                                              
                                              showPage(info.event.url,info.event._def.title);
                                               }
                                            }
                                        });
                                        new_var_cal.render();
                            },
                                error: function() {
                                  
                                }
                            });
                                                       
            });
        
        
            $(document).on('click','.fc-prev-button', function() {
                var events;
                var current_month = $('.fc-center').find('h2').text();
                current_month = current_month.split(' ');                               
                var month_ajax = months[current_month[0]];
                var pathname = window.location.href.split('/')[5].split('calendar')[1];
               
                
               
                $.ajax({
                            url: "/warehouse/shipping-request/calendar-ajax"+pathname+"",
                                type: "post",
                                data: {month_ajax: month_ajax},
                                dataType: "json",
                                success: function (response) {
                                    if($.isEmptyObject(response)){
                                        events = '';
                                    }else{
                                        events = response;
                                    } 
                                   


                                    
                                        
                                        new_var_cal.destroy();
                                        var today = new Date();                                        
                                        day =  today.getDate(),
                                        year = today.getFullYear();                                        
                                        var calendarEl = document.getElementById('calendar');    
                                        new_var_cal = new FullCalendar.Calendar(calendarEl, {
                                          plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                                          height: 'parent',
                                          header: {
                                            left: 'prev,next',
                                            center: 'title',
                                            right: ''
                                          },
                                          defaultView: 'dayGridMonth',
                                          defaultDate: year+'-'+month_ajax+'-'+day,
                                          navLinks: true, // can click day/week names to navigate views
                                          editable: true,
                                          eventLimit: true, // allow "more" link when too many events
                                          events: events,
                                          
                                           eventClick: function(info) {
                                             info.jsEvent.preventDefault(); // don't let the browser navigate
                                             if (info.event.url) {
                                               
                                               showPage(info.event.url,info.event._def.title);
                                                }
                                             }
                                        });
                                        new_var_cal.render();
                                },
                                error: function() {
                                  
                                }
                            });
            });

            

}

    </script>
    <style type="text/css">
        .fc-title{
            color: white;
        }
    </style>








