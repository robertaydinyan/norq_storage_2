<?php


namespace app\components;

use app\models\User;
use app\modules\billing\models\Tariff;
use app\modules\warehouse\models\Shipping;
use app\modules\warehouse\models\ShippingRequest;
use app\modules\warehouse\models\Warehouse;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use NumberFormatter;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

/**
 * Class Helper
 * @package app\components
 */
class Helper
{

    /**
     * @param $number
     * @param string $locale
     * @return false|string
     */
    public static function numberToWords($number, $locale = "hy") {
        $format = new NumberFormatter("hy", NumberFormatter::SPELLOUT);
        return $format->format($number);
    }

    /**
     * Check decimal
     *
     * @param $val
     * @return bool
     */
    public static function is_decimal($val)
    {
        return is_numeric($val) && floor($val) != $val;
    }

    /**
     * Decimal format
     *
     * @param $value
     * @return string
     */
    public static function decimal($value)
    {
        return number_format((float)$value, 2, '.', '');
    }

    /**
     * @param $decimal
     * @return int
     */
    public static function removeUselessZeroDigits($decimal)
    {
        return $decimal + 0;
    }

    /**
     * Generate leading IDs
     *
     * @param $value
     * @param null $hasString
     * @param int $length
     * @return bool|string
     */
    public static function leadingId($value, $hasString = null, $length = 5)
    {
        if (!is_null($value)) {
            $leadingId = sprintf('%0' . $length . 'd', $value);
            $leadingIdWithString = $hasString . '-' . $leadingId;

            return !is_null($hasString) ? $leadingIdWithString : $leadingId;
        }

        return false;
    }

    /**
     * Database Transaction
     *
     * ex.   dbTransaction(
    function () use ($balance) {
    $balance->balance = $this->balance;
    $balance->user_id = $this->id;
    $this->balance    = $this->getBalance() + $balance->getDelta();

    return $balance->save() && $this->save();
    }
    );
     * @param callable $callback
     * @throws \yii\db\Exception
     */
    public function dbTransaction(callable $callback)
    {
        $transaction = \Yii::$app->db->beginTransaction();

        try {
            //if callback returns true than commit transaction
            if (call_user_func($callback)) {
                $transaction->commit();
                \Yii::trace('Transaction wrapper success');
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        $transaction->rollBack();
    }

    /**
     * Draw categories tree
     *
     * @param array $array
     * @param int $level
     */
    public static function drawCategoryTree(array $array, $level = 0)
    {
        if (!empty($array)) {
            foreach ($array as $node) {
                if (isset($node['child'])) {
                    echo '<li data-category="' . $node["id"] . '" class="base-tree">
                              <span class="caret">
                                  <a href="javascript:void(0);">' . $node['name'] . '</a>
                              </span>';
                } else {
                    echo '<li data-category="' . $node["id"] . '" class="base-tree">
                              <a href="javascript:void(0);" class="showModalButton" value="' . Url::to(['tariff/update', 'id' => $node['id']]) . '" title="' . Yii::t('app', 'Тариф') . '">' . $node['name'] . '</a>';
                }

                if (isset($node['child']) && !empty($node['child'])) {
                    echo '<ul class="nested">';
                    self::drawCategoryTree($node['child'], $level + 1);
                    echo '</ul>';
                }
                echo '</li>';
            }
        } else {
            throw new InvalidConfigException('Category cannot be empty.');
        }
    }
    /**
     * Main menu
     *
     * @throws \Exception
     */
    public static function constructMenu($module = null)
    {

        $modules = ['billing', 'crm', 'task', 'hr', 'fastnet', 'rbac', 'warehouse'];
        $lang = Yii::$app->request->get('lang');

        if (in_array($module, $modules)) {

            NavBar::begin([ // отрываем виджет
                'brandLabel' => false, // название организации
                'brandUrl' => \Yii::$app->homeUrl, // ссылка на главную страницу сайта
                'options' => [
                    'class' => 'main-header navbar navbar-expand  main-header2', // стили главной панели
                ],
                'renderInnerContainer' => false,
            ]);

            $billing = [
                ['label' => Yii::t('app', 'Ip Հասցե'), 'url' => ['/billing/configs/index']],
                ['label' => Yii::t('app', 'Ip Ալեհավաք'), 'url' => ['/billing/configs/antenna-ip']],
                ['label' => Yii::t('app', 'Ալիքի կատեգորիա'), 'url' => ['/billing/configs/config-channel-category']],
                ['label' => Yii::t('app', 'Ալիքի որակ'), 'url' => ['/billing/configs/config-channel-quality']],
                ['label' => Yii::t('app', 'Ալիքի հեռարձակման լեզուն'), 'url' => ['/billing/configs/config-channel-broadcast-language']],
                ['label' => Yii::t('app', 'TV ալիք'), 'url' => ['/billing/configs/config-tv-channel']],
                ['label' => Yii::t('app', 'TV փաթեթ'), 'url' => ['/billing/configs/config-tv-packet']],
                ['label' => Yii::t('app', 'Երկրներ'), 'url' => ['/billing/configs/countries-list']],
                ['label' => Yii::t('app', 'Համայնք'), 'url' => ['/billing/community/']],
                ['label' => Yii::t('app', 'Արձակուրդի տարբերակներ'), 'url' => ['/billing/configs/vacation-options']],
                ['label' => Yii::t('app', 'Խզման տարբերակներ'), 'url' => ['/billing/configs/disruption-options']],

                [
                    'label' => Yii::t('app', 'Առաջադրանքներ'),
                    'url' => '#',
                    'items' => [
                        ['label' => Yii::t('app', 'Տարբերակներ'), 'url' => '/billing/configs/task-options'],
                        ['label' => Yii::t('app', 'Գերակայություն'), 'url' => '/billing/configs/task-priority'],
                    ],
                ],
            ];

//            $billing = [
//                ['label' => Yii::t('app', 'Тарифы'), 'url' => ['/billing/tariff/index']],
//                ['label' => Yii::t('app', 'Услуги'), 'url' => ['/billing/services/index']],
//                ['label' => Yii::t('app', 'Акции'), 'url' => ['/billing/share/index']],
//                ['label' => Yii::t('app', 'Клиенты'), 'url' => ['/billing/client/index']],
//                [
//                    'label' => Yii::t('app', 'Сотрудники'),
//                    'url' => ['/billing/staff/index'],
//                    'visible' => Yii::$app->user->identity->role == User::ROLE_ADMIN
//                ],
//                ['label' => Yii::t('app', 'Товары'), 'url' => ['/crm/product/index']],
//                [
//                    'label' => Yii::t('app', 'Оплаты'),
//                    'url' => ['/billing/payment/index'],
//                    'visible' => Yii::$app->user->identity->role == User::ROLE_MANAGER || Yii::$app->user->identity->role == User::ROLE_ADMIN
//                ],
//                ['label' => Yii::t('app', 'Справочник'), 'url' => ['/billing/configs/index']],
//            ];

            $crm = [
                [
                    'label' => Yii::t('app', 'Ֆիզ․ անձ'),
                    'url' => ['/crm/fast-contact/index']
                ],
                [
                    'label' => Yii::t('app', 'Կազմակերպություն'),
                    'url' => ['/crm/fast-company/index']
                ],
                [
                    'label' => Yii::t('app', 'Գանձապահ'),
                    'url' => ['/crm/cashier/index'],
                    'visible' => Yii::$app->user->identity->role == User::ROLE_ADMIN
                ],
                [
                    'label' => Yii::t('app', 'Աշխատակիցներ'),
                    'url' => ['/crm/user/index'],
                    'visible' => Yii::$app->user->identity->role == User::ROLE_ADMIN
                ],
                [
                    'label' => Yii::t('app', 'Տպել ՀԴՄ կտրոն'),
                    'url' => ['/crm/cash-register-receipt/index'],
                    'visible' => Yii::$app->user->can('printCashRegisterReceipt')
                ],
                [
                    'label' => Yii::t('app', 'Roles'),
                    'url' => ['/rbac/rule/index'],
                    'visible' => Yii::$app->user->identity->role == User::ROLE_ADMIN
                ],
            ];

            $task = [
                ['label' => Yii::t('app', 'Առաջադրանքներ'), 'url' => ['/task/task/index']],
            ];

            $hr = [

                ['label' => Yii::t('app', 'Департаменты'), 'url' => ['/hr/departments/index']],
                ['label' => Yii::t('app', 'Должности'), 'url' => ['/hr/positions/index']],
                ['label' => Yii::t('app', 'Роли'), 'url' => ['/hr/roles/index']],
                ['label' => Yii::t('app', 'Персоны'), 'url' => ['/hr/persons/index']],
            ];

            $fastnet = [
                ['label' => Yii::t('app', 'Ծառայություններ'), 'url' => ['/fastnet/tariff/index']],
                ['label' => Yii::t('app', 'Գործարքներ'), 'url' => ['/fastnet/deal/index']],
                ['label' => Yii::t('app', 'ՎՃարումներ'), 'url' => ['/fastnet/deal-payment-log/index']],
                ['label' => Yii::t('app', 'Հաճախորդներ'), 'url' => ['/fastnet/contacts/index']],
                ['label' => Yii::t('app', 'Բազային կայաններ'), 'url' => ['/fastnet/base-station/index']],
                ['label' => Yii::t('app', 'Դատա'), 'url' => ['/fastnet/data/index']],
                ['label' => Yii::t('app', 'Գոտիներ'), 'url' => ['/fastnet/zone/index']],
                ['label' => Yii::t('app', 'Զեղչեր'), 'url' => ['/fastnet/deal-sale/index']],
                ['label' => Yii::t('app', 'Անջատման օր'), 'url' => ['/fastnet/disabled-day/index']],
            ];

            $newWhCount = Warehouse::find()->where(['>=', 'created_at' , Carbon::now()->toDateString()])->count();
            if($newWhCount == 0){
                $newWhCount = '';
            }
            $newSHipping = ShippingRequest::find()->where(['>=', 'created_at' , Carbon::now()->toDateString()])->count();
            if($newSHipping == 0){
                $newSHipping = '';
            }
            $warehouse = array();

            if (\app\rbac\WarehouseRule::can('warehouse', 'view'))
                array_push($warehouse, ['label' => Yii::t('app', 'Main warehouse'), 'url' => ['/warehouse/warehouse/view?id=20&lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('warehouse', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Warehouses'), 'url' => ['/warehouse/warehouse?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('product', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'goods'), 'url' => ['/warehouse/product?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('shippingRequest', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Documents'), 'url' => ['/warehouse/shipping-request/documents?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('shippingRequest', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Polls'), 'url' => ['/warehouse/shipping-request?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('qtyType', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Directory'), 'url' => ['/warehouse/qty-type?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('report', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Reports'), 'url' => ['/warehouse/reports?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('complectation', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Composition'), 'url' => ['/warehouse/complectation?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('payment', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Payments'), 'url' => ['/warehouse/payments?lang=' . $lang]]);
            if (\app\rbac\WarehouseRule::can('users', 'index'))
                array_push($warehouse,['label' => Yii::t('app', 'Users'), 'url' => ['/warehouse/users?lang=' . $lang]]);

            $rbac = [
                ['label' => Yii::t('app', 'Rule'), 'url' => ['/rbac/rule/index']],
                ['label' => Yii::t('app', 'Route'), 'url' => ['/rbac/route/index']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['/rbac/assignment/index']],
                ['label' => Yii::t('app', 'Item'), 'url' => ['/rbac/item/index']],
            ];

            switch ($module) {
                case $modules[0]:
                    $result = $billing;
                    break;
                case $modules[1]:
                    $result = $crm;
                    break;
                case $modules[2]:
                    $result = $task;
                    break;
                case $modules[3]:
                    $result = $hr;
                    break;
                case $modules[4]:
                    $result = $fastnet;
                    break;
                case $modules[5]:
                    $result = $rbac;
                    break;
                case $modules[6]:
                    $result = $warehouse;
                    break;
                default:
                    $result = $billing;
                    break;
            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav w-100'], // стили ul
                'items' => $result
            ]);

            NavBar::end(); // закрываем виджет

        }
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     * @throws \Exception
     */
    public static function generateRandom($min = 1, $max = 9999)
    {
        if (function_exists('random_int')) {
            return random_int($min, $max); // more secure
        } else if (function_exists('mt_rand')) {
            return mt_rand($min, $max); // faster
        }

        return rand($min, $max); // old
    }

    /**
     * @return array[]
     */
    public static function tariffCategory()
    {
        $internet = Tariff::find()->select('id, name')->where(['is_internet' => true])->asArray()->all();
        $tv = Tariff::find()->select('id, name')->where(['is_tv' => true])->asArray()->all();
        $internet_tv = Tariff::find()->select('id, name')->where(['is_internet' => true])->andWhere(['is_tv' => true])->asArray()->all();

        $categories = [
            0 => [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Интернет',
                'icon' => '/img/category/hotspot.png',
                'child' => $internet
            ],
            1 => [
                'id' => 2,
                'parent_id' => null,
                'name' => 'TV',
                'icon' => '/img/category/tv.png',
                'child' => $tv
            ],
            2 => [
                'id' => 3,
                'parent_id' => null,
                'name' => 'Интернет + TV',
                'icon' => '/img/category/internet-tv.png',
                'child' => $internet_tv
            ]
        ];

        return $categories;
    }

    /**
     * @param $tariff_id
     * @return string
     * @throws \Exception
     */
    public static function tariffCategoryGroup($tariff_id)
    {
        if (!empty($tariff_id)) {
            $tariff = Tariff::findOne($tariff_id);

            if (!empty($tariff)) {
                $tariff_name = [];

                if ($tariff->is_internet == 1 && $tariff->is_tv == 0) {
                    $tariff_name[] = Yii::t('app', 'Интернет');
                }

                if ($tariff->is_tv == 1 && $tariff->is_internet == 0) {
                    $tariff_name[] = Yii::t('app', 'TV');
                }

                if ($tariff->is_internet == 1 && $tariff->is_tv == 1) {
                    $tariff_name[] = Yii::t('app', 'Интернет') . ' + ' . Yii::t('app', 'TV');
                }

                if ($tariff->is_internet != 1 && $tariff->is_tv != 1) {
                    $tariff_name[] = Yii::t('app', 'Тариф не выбран');
                }

                return rtrim(implode(' + ', $tariff_name), ' + ');
            } else {
                throw new \Exception('Cannot find Tariff with ID: ' . $tariff_id);
            }
        } else {
            throw new \Exception('Tariff ID cannot be empty!');
        }
    }

    /**
     * @param $tariffSum
     * @param $actualPrice
     * @param $type
     * @return float|int
     */
    public static function proposedPrice($tariffSum, $actualPrice, $type)
    {
        if (!is_null($tariffSum) && !is_null($actualPrice)) {

            // 1 - %, 2 - AMD
            if ($type == 1) {
                $price = ($tariffSum / 100) * $actualPrice;
                $tariffSum += $price;
            } else {
                $tariffSum += $actualPrice;
            }

            return $tariffSum;

        } else {
            return $tariffSum;
        }
    }

    /**
     * @param $number
     * @return int|string
     */
    public static function formatNumberString($number)
    {
        if (!is_null($number)) {
            return number_format($number, 0, ',', ' ');
        } else {
            return 0;
        }
    }


    /**
     * @param $url
     * @return false|string[]|null
     */
    public static function explodeUrl($url)
    {
        if (!is_null($url)) {
            return explode('/', $url);
        } else {
            return null;
        }
    }

    /**
     * @param $url
     * @param $module_id
     * @param $controller
     * @return bool|string
     */
    public static function isModuleUrl($url, $module_id, $controller)
    {
        if (!is_null($module_id)) {
            $explodeUrl = self::explodeUrl($url);

            if ($explodeUrl[1] == $module_id && $explodeUrl[2] == $controller) {
                return true;
            } else {
                return false;
            }
        } else {
            return Url::current();
        }
    }

    /**
     * @param $url
     * @param bool $isModule
     * @return string
     */
    public static function trimActionFromUrl($url, $isModule = true)
    {
        if (!is_null($url)) {
            $explode = self::explodeUrl($url);

            if ($isModule === true) {
                if (isset($explode[3])) {
                    unset($explode[3]);
                }
            } else {
                if (isset($explode[2])) {
                    unset($explode[2]);
                }
            }

            return implode('/', $explode);
        }

        return Url::current();
    }

    public static function currentUrl($url)
    {
        if (!is_null($url)) {
            $explode = self::explodeUrl($url);
        } else {
            return Url::current();
        }
    }

    /**
     * @return string[]
     */
    public static function getMenuList()
    {
        return [
            '1' => 'Лиды',
            '2' => 'Компании',
            '3' => 'Контакты',
            '4' => 'Товары',
            '5' => 'Сделки',
        ];
    }

    /**
     * @return array[]
     */
    public static function asideMenu()
    {

        return [
            [
                'url' => Url::to(['/warehouse/warehouse']),
                'title' => Yii::t('app', 'Warehouse'),
                'icon' => 'sidebar-icon sidebar-icon-task-management',
            ],
//            [
//                'url' => Url::to(['/billing/tariff']),
//                'title' => Yii::t('app', 'Billing'),
//                'icon' => 'sidebar-icon-billing',
//            ],
//            [
//                'url' => Url::to(['/crm/lead']),
//                'title' => Yii::t('app', 'CRM'),
//                'icon' => 'sidebar-icon-crm',
//            ],
//            [
//                'url' => Url::to(['/task/tasks']),
//                'title' => Yii::t('app', 'Task Management'),
//                'icon' => 'sidebar-icon-directory',
//            ],
//            [
//                'url' => Url::to(['/hr/departments']),
//                'title' => Yii::t('app', 'HR'),
//                'icon' => 'sidebar-icon-directory',
//            ],
 
        ];
    }

    /**
     * @param $path
     * @return bool
     */
    public static function createDirectory($path)
    {
        if (!is_null($path)) {
            if (!is_dir($path) && !file_exists($path)) {
                return mkdir($path, 0777, true);
            }
        }

        return false;
    }

    /**
     * @param $dir
     * @return bool
     */
    public static function deleteDirectoryWithContent($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!self::deleteDirectoryWithContent($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

    /**
     * Unlink a file, which handles symlinks.
     * @see https://github.com/luyadev/luya/blob/master/core/helpers/FileHelper.php
     * @param string $filename The file path to the file to delete.
     * @return boolean Whether the file has been removed or not.
     */
    public static function unlinkFile($filename)
    {
        // try to force symlinks
        if (is_link($filename)) {
            $sym = @readlink($filename);
            if ($sym) {
                return is_writable($filename) && @unlink($filename);
            }
        }

        // try to use real path
        if (realpath($filename) && realpath($filename) !== $filename) {
            return is_writable($filename) && @unlink(realpath($filename));
        }

        // default unlink
        return is_writable($filename) && @unlink($filename);
    }

    /**
     * Get extension and name from a file for the provided source/path of the file.
     *
     * @param string $sourceFile The path of the file
     * @return object With extension and name keys.
     */
    public static function getFileInfo($sourceFile)
    {
        $path = pathinfo($sourceFile);

        return (object)[
            'extension' => (isset($path['extension']) && !empty($path['extension'])) ? mb_strtolower($path['extension'], 'UTF-8') : false,
            'name' => (isset($path['filename']) && !empty($path['filename'])) ? $path['filename'] : false,
            'source' => $sourceFile,
            'sourceFilename' => (isset($path['dirname']) && isset($path['filename'])) ? $path['dirname'] . DIRECTORY_SEPARATOR . $path['filename'] : false,
        ];
    }

    public static function uploadImage($path, $file)
    {
        if (!empty($path) && !empty($file)) {
            $status = false;

            if (count($file) > 1) {
                foreach ($file as $key => $val) {
                    $ext = pathinfo($val, PATHINFO_EXTENSION);
                    $name = microtime() . '.' . $ext;
                    $name = str_replace(' ', '', $name);
                    $uploadfile = $path . '/' . $name;

                    if (move_uploaded_file($file[$key], $uploadfile)) {
                        $status = true;
                    }
                }
            }

            return $status;
        }
    }

    /**
     * @param $date
     * @return false|string
     */
    public static function getlastDayMonthForPaymentLog($date)
    {
        return date("Y-m-t", strtotime($date));
    }

    /**
     * @param $date
     * @param bool $time
     * @param false $armenianFormat
     * @return false|string
     */
    public static function formatDate($date, $time = true, $armenianFormat = false)
    {
        if (empty($date)) {
            return null;
        }

        if (!$time) {
            return date($armenianFormat ? 'd-m-Y' : 'Y-m-d', strtotime($date));
        } else {
            return date($armenianFormat ? 'd-m-Y H:i:s' : 'Y-m-d H:i:s', strtotime($date));
        }
    }

    /**
     * A mathematical decimal difference between two informed dates
     *
     * Automatic conversion on dates informed as string.
     * Possibility of absolute values (always +) or relative (-/+)
     *
     * @param $dateTo
     * @param $dateFrom
     * @param string $strInterval
     * @param false $relative
     * @return float|int
     */
    public static function dateDifference($dateTo, $dateFrom = '', $strInterval = 'd', $relative = false) {

        $dateFrom = !empty($dateFrom) ? date_create($dateFrom) : date_create(date('Y-m-d'));
        $dateTo = !empty($dateTo) ? date_create($dateTo) : date_create(date('Y-m-d'));

        $diff = date_diff($dateFrom, $dateTo, !$relative);

        switch($strInterval) {
            case "y":
                $total = $diff->y + $diff->m / 12 + $diff->d / 365.25;
                break;
            case "m":
                $total= $diff->y * 12 + $diff->m + $diff->d/30 + $diff->h / 24;
                break;
            case "d":
                $total = $diff->y * 365.25 + $diff->m * 30 + $diff->d + $diff->h/24 + $diff->i / 60;
                break;
            case "h":
                $total = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i/60;
                break;
            case "i":
                $total = (($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i + $diff->s/60;
                break;
            case "s":
                $total = ((($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h) * 60 + $diff->i)*60 + $diff->s;
                break;
        }

        return $diff->invert ? -1 * $total : $total;
    }

    public static function dateNotTime($date)
    {
        return date("Y-m-d", strtotime($date));
    }

    /**
     * @param $amount
     * @param $work_price
     * @param $price
     * @param int $start_deal
     * @return mixed
     */
    public static function debt($amount, $work_price, $price, $start_deal = 0)
    {
        if ((int)$start_deal == 1) {
            $total = $price - ($amount + $work_price);
        } else {
            $total = $price - $amount;
        }

        return $total;
    }

    public static function getPaidColor($price)
    {
        $date = date('d');

        $color = [];

        if ((int)$date > 15 && $price > 0) {
            /*ne oplachen / prosrochen*/
            $color['color'] = 'rgb(255, 0, 0)';
            $color['text'] = Yii::t('app', 'Просрочено');
        } else if ((int)$date > 15 && $price < 0) {
            /*ne oplachen / prosrochen*/
            $color['color'] = 'rgb(0, 176, 80)';
            $color['text'] = Yii::t('app', 'Просрочено');
        } elseif ($date <= 15 && $price <= 0) {
            /*oplachen*/
            $color['color'] = 'rgb(0, 176, 80)';
            $color['text'] = Yii::t('app', 'Проведено');
        } elseif ($date <= 15 && $price < 0) {
            /*schet vistavlen*/
            $color['color'] = 'rgb(146, 208, 80)';
            $color['text'] = Yii::t('app', 'Счёт выставлен');
        } else {
        }

        return $color;
    }

    /**
     * @param null $price
     * @param null $dayCount
     * @return float|int
     */
    private function mathStartDate($price, $date)
    {
        $dayCount = date_parse($date);

        $days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('y', strtotime($date)));

        $dayCountRes = $days - $dayCount['day'];

        return $result = ($price / $days) * ($dayCountRes + 1);
    }

    /**
     * @param $price
     * @param $holiday_start
     * @param $holiday_end
     * @param $connection_day
     * @return float|int
     * @throws \Exception
     */
    private function currentMonthHolidayPrice($price, $holiday_start, $holiday_end, $connection_day)
    {

        $hs_day = new DateTime($holiday_start);
        $c_day = new DateTime($connection_day);
        $start_day = $hs_day->diff($c_day);
        $dayCount = date_parse($holiday_end);
        $days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($holiday_end)), date('y', strtotime($holiday_end)));
        $result = ($price / $days) * ($start_day->days + ($days - $dayCount['day']));
        return $result;


    }

    /**
     * @param $price
     * @param $holiday_start
     * @param null $connection_day
     * @return float|int
     * @throws \Exception
     */
    private function firstMonthHolidayPrice($price, $holiday_start, $connection_day = null)
    {

        $connection_day = !$connection_day ? date('Y-m-01') : $connection_day;
        $hs_day = new DateTime($holiday_start);
        $c_day = new DateTime($connection_day);
        $start_day = $hs_day->diff($c_day);
        $days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($holiday_start)), date('y', strtotime($holiday_start)));
        $result = ($price / $days) * $start_day->days;
        return $result;
    }

    /**
     * @param null $price
     * @param null $dayCount
     * @return float|int
     */
    private function mathEndDatePlus($price = null, $dayCount = null, $startDay = null)
    {

        $dayCountEnd = date_parse($dayCount);
        $dayCountStart = date_parse($startDay);
        $dayCount = $dayCountEnd['day'] - $dayCountStart['day'];
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
        return $result = ($price / $days) * ($dayCount + 1);
    }

    /**
     * @param null $price
     * @param null $dayCount
     * @return float|int|mixed|null
     */
    private function mathEndDateMinus($price = null, $dayCount = null)
    {
        $dayCount = date_parse($dayCount);
        $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('y'));
        return $result = (($price / $days) * $dayCount['day']) - $price;
    }


    /**
     * @param $price
     * @param null $start_date
     * @param null $finish_date
     * @param null $holiday_start
     * @param null $holiday_end
     * @param null $connection_day
     * @return float|int
     */
    public function mathPriceMonth($price, $start_date = null, $finish_date = null, $holiday_start = null, $holiday_end = null, $connection_day = null)
    {
        if (is_null($holiday_start) || is_null($holiday_end)) {
            if ($start_date && !$finish_date) {
                //miacman gumar
                $result = $this->mathStartDate($price, $start_date);
            } else {
                // paymanagri xzum
                $result = $this->mathEndDatePlus($price, $finish_date, $start_date);
            }

        } else {
            $holidayArr = [];
            $holidayArr['totalDay'] = $this->holidayDays($holiday_end, $holiday_start);
            $holidayArr['currentBalanceDay'] = $this->holidayDays($holiday_end);
            $holidayArr['totalPrice'] = 0;
            $begin = new DateTime(date('Y-m-d', strtotime($holiday_start)));
            $end = new DateTime(date('Y-m-d', strtotime($holiday_end . '+ 1 month')));

            $interval = DateInterval::createFromDateString('1 month');


            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $key => $dt) {
                if ($dt->format("Y-m") && ($dt->format("Y-m") <= date("Y-m", strtotime($holiday_end)))) {
                    if (($dt->format("Y-m") == date("Y-m", strtotime($holiday_start))) && ($dt->format("Y-m") == date("Y-m", strtotime($holiday_end)))) {

                        $monthPrice = $this->currentMonthHolidayPrice($price, $holiday_start, $holiday_end, $connection_day);
                        $holidayArr['currentBalanceWithMonth'][$dt->format("Y-m")] = $monthPrice;
                        $holidayArr['totalPrice'] += $monthPrice;

                    } elseif (($dt->format("Y-m") == date("Y-m", strtotime($holiday_start))) && ($dt->format("Y-m") != date("Y-m", strtotime($holiday_end)))) {
                        $monthPrice = $this->firstMonthHolidayPrice($price, $holiday_start, $connection_day);
                        $holidayArr['currentBalanceWithMonth'][$dt->format("Y-m")] = $monthPrice;
                        $holidayArr['totalPrice'] += $monthPrice;

                    } elseif (($dt->format("Y-m") == date("Y-m", strtotime($holiday_end))) && ($dt->format("Y-m") != date("Y-m", strtotime($holiday_start)))) {
                        $monthPrice = $this->mathStartDate($price, $holiday_end);
                        $holidayArr['currentBalanceWithMonth'][$dt->format("Y-m")] = $monthPrice;
                        $holidayArr['totalPrice'] += $monthPrice;
                    } else {
                        $holidayArr['currentBalanceWithMonth'][$dt->format("Y-m")] = 0;

                    }

                }
            }

            $result = $holidayArr;

        }

        return $result;
    }

    /**
     * @param $holiday_end
     * @param null $holiday_start
     * @return false|int
     * @throws \Exception
     */
    public function holidayDays($holiday_end, $holiday_start = null)
    {

        if (!$holiday_start) {

            $holiday_start = date('Y-m-d');
        }

        $date1 = new DateTime($holiday_end);
        $date2 = new DateTime($holiday_start);
        if ($date2 > $date1) {
            $res = 'Ավարտված է';

        } else {
            $interval = $date1->diff($date2);
            $res = $interval->days . ' օր';
        }


        return $res;

    }


    public function mathPayTypeChek($price = null, $payType)
    {
        if ($payType = 0) {
            return $this->mathEndDateMinus($price, date('y-m-d'));
        } else {
            return $this->mathEndDatePlus($price, date('y-m-d'));
        }
    }

    /**
     * @param false $internet
     * @param bool $tv
     * @return string
     */
    public static function tariffIcon($internet, $tv)
    {
        $icon = '';

        if (!empty($internet) && empty($tv)) {
            $icon = Yii::getAlias('@web') . '/img/category/hotspot.png';
        }

        if (!empty($tv) && empty($internet)) {
            $icon = Yii::getAlias('@web') . '/img/category/tv.png';
        }

        if (!empty($internet) && !empty($tv)) {
            $icon = Yii::getAlias('@web') . '/img/category/internet-tv.png';
        }

        return $icon;
    }

    /**
     * @param $string
     * @param int $length
     * @param string $append
     * @return string
     */
    public static function truncateText($string, $length = 100, $append = "&hellip;")
    {
        $string = trim($string);

        if (strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }

        return $string;
    }

    /**
     * @param $datetime
     * @param false $full
     * @return string
     * @throws \Exception
     */
    public static function timeElapsedString($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function importForm()
    {
        $importInputText = Yii::t('app', 'Ընտրել ներմուծման ֆայլ');
        $importInput = Html::input('file', 'import_deal_field', null, ['class' => 'form-control', 'id' => 'deal-import-deal']);
        $csrfInput = Html::input('hidden', '_csrf', Yii::$app->request->csrfToken);

        $importButton = Html::submitButton(Yii::t('app', 'Ներմուծում'), [
            'type' => 'button',
            'title' => Yii::t('app', 'Ներմուծում'),
            'class' => 'btn btn-primary ml-2'
        ]);

        $fileInputLabel = Html::label($importInputText.$importInput, 'deal-import-deal', ['class' => 'btn btn-light btn-file ml-2 mb-0']);

        $renderFields = Html::tag('div', $fileInputLabel.$importButton);

        return Html::tag('form', $csrfInput.$renderFields, [
            'action' => Url::toRoute('import-deal'),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ]);
    }
}