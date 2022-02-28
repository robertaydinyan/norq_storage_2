<?php

namespace yii2mod\rbac\controllers;

use app\modules\rbac\controllers\ItemController;
use yii\rbac\Item;

/**
 * Class PermissionController
 *
 * @package app\modules\rbac\controllers
 */
class PermissionController extends ItemController
{
    /**
     * @var int
     */
    protected $type = Item::TYPE_PERMISSION;

    /**
     * @var array
     */
    protected $labels = [
        'Item' => 'Permission',
        'Items' => 'Permissions',
    ];
}
