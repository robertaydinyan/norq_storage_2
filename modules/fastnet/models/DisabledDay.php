<?php

namespace app\modules\fastnet\models;

use Carbon\Carbon;
use Yii;

/**
 * This is the model class for table "f_deal_disabled_day".
 *
 * @property int $id
 * @property int|null $disabled_day
 * @property int|null $disabled_price_day
 * @property int|null $price
 * @property string|null $message
 */
class DisabledDay extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'f_deal_disabled_day';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['disabled_day', 'disabled_price_day'], 'integer'],
            [['price', 'message'], 'safe'],
            ['disabled_price_day', 'compare', 'compareAttribute' => 'disabled_day', 'operator' => '>='],
            ['disabled_day', 'compare', 'compareAttribute' => 'disabled_price_day', 'operator' => '<=']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'disabled_day' => 'Անջատման օր',
            'disabled_price_day' => 'Գումարի հաշվարկի կասեցման օր',
            'price' => 'Նվազագույն գումար, որի դեպքում չենք կասեցնում',
            'message' => 'Message',
        ];
    }

    /**
     * @return array
     */
    public function disabledDays()
    {
        $today = Carbon::today();
        $dates = [];

        for($i=1; $i < $today->daysInMonth + 1; ++$i) {
            $dates[] = Carbon::createFromDate($today->year, $today->month, $i)->format('d');
        }

        # Array key start with 1 (day)
        array_unshift($dates,"");
        unset($dates[0]);

        return $dates;
    }

    /**
     * @return int|null
     */
    public static function disabledPrice()
    {
        $disabled = DisabledDay::findOne(1);
        return $disabled->price;
    }
}
