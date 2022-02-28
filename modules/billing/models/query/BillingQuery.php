<?php

namespace app\modules\billing\models\query;

class BillingQuery extends \yii\db\ActiveQuery
{

    public static function staff()
    {
        $staffList['Staff'] = [
            [
                'id'           => 1,
                'name'         => 'Армен',
                'last_name'    => 'Петросян',
                'position'     => 'Инженер',
                'warehouse_id' => 1
            ],
            [
                'id'           => 2,
                'name'         => 'Карен',
                'last_name'    => 'Оганесян',
                'position'     => 'Директор',
                'warehouse_id' => 2
            ],
            [
                'id'           => 3,
                'name'         => 'Ани',
                'last_name'    => 'Тумасян',
                'position'     => 'Оператор',
                'warehouse_id' => 1
            ],
            [
                'id'           => 4,
                'name'         => 'Саргис',
                'last_name'    => 'Багдасарян',
                'position'     => 'Инженер',
                'warehouse_id' => 2
            ],
            [
                'id'           => 5,
                'name'         => 'Артур',
                'last_name'    => 'Минасян',
                'position'     => 'Ответственный',
                'warehouse_id' => 1
            ],
            [
                'id'           => 6,
                'name'         => 'Норайр',
                'last_name'    => 'Петросян',
                'position'     => 'Ответственный',
                'warehouse_id' => 2
            ]
        ];

        $branchList['Branch'] = [
            [
                'id' => 1,
                'name' => 'FastNet - Масисский филиал',
            ],
            [
                'id' => 2,
                'name' => 'FastNet - Ереванский филиал',
            ]
        ];

        return array_merge($staffList, $branchList);
    }

}