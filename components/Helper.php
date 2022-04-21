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

            $warehouse = [
                ['label' => Yii::t('app', 'Main warehouse'), 'url' => ['/warehouse/warehouse/view?id=20&lang=' . $lang]],
                ['label' => Yii::t('app', 'Warehouses'), 'url' => ['/warehouse/warehouse?lang=' . $lang]],
                ['label' => Yii::t('app', 'goods'), 'url' => ['/warehouse/product?lang=' . $lang]],
                ['label' => Yii::t('app', 'Documents'), 'url' => ['/warehouse/shipping-request/documents?lang=' . $lang]],
                ['label' => Yii::t('app', 'Polls'), 'url' => ['/warehouse/shipping-request?lang=' . $lang]],
                ['label' => Yii::t('app', 'Directory'), 'url' => ['/warehouse/qty-type?lang=' . $lang]],
                ['label' => Yii::t('app', 'Reports'), 'url' => ['/warehouse/reports?lang=' . $lang]],
                ['label' => Yii::t('app', 'Services'), 'url' => ['/warehouse/complectation?lang=' . $lang]],
                ['label' => Yii::t('app', 'Payments'), 'url' => ['/warehouse/payments?lang=' . $lang]],
                ['label' => Yii::t('app', 'Users'), 'url' => ['/warehouse/users?lang=' . $lang]],
            ];

            $rbac = [
                ['label' => Yii::t('app', 'Rule'), 'url' => ['/rbac/rule/index']],
                ['label' => Yii::t('app', 'Route'), 'url' => ['/rbac/route/index']],
                ['label' => Yii::t('app', 'Assignment'), 'url' => ['/rbac/assignment/index']],
                ['label' => Yii::t('app', 'Item'), 'url' => ['/rbac/item/index']],
            ];

            switch ($module) {
               
                case $modules[5]:
                    $result = $rbac;
                    break;
                case $modules[6]:
                    $result = $warehouse;
                    break;
                default:
                    $result = $warehouse;
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
}