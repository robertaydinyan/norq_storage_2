<?php

namespace app\components;

use Yii;
use yii\base\InvalidParamException;

class Constant
{

    const YesNo_Yes = 1;
    const YesNo_No = 0;

    /**
     * @param null $key
     * @param bool $icon
     * @return mixed
     */
    public static function getYesNoItems($key = null, $icon = true)
    {

        $items = [
            self::YesNo_Yes => $icon ? '<i class="fas fa-check text-success"></i>' : Yii::t('app', 'Այո'),
            self::YesNo_No => $icon ? '<i class="fas fa-times text-danger"></i>' : Yii::t('app', 'Ոչ'),
        ];

        return self::getItems($items, (int) $key);
    }

    /**
     * @param $items
     * @param null $key
     * @return mixed
     */
    private static function getItems($items, $key = null)
    {
        if ($key !== null) {
            if (key_exists($key, $items)) {
                return $items[$key];
            }
            throw new InvalidParamException( 'Unknown key:' . $key );
        }

        return $items;
    }

}