<?php

namespace app\modules\warehouse\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "s_group_product".
 *
 * @property int $id
 * @property string $name
 * @property int|null $group_id
 * @property int|null $group_order
 */
class GroupProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_group_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['group_id', 'group_order'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
            'group_id' => Yii::t('app', 'Parent Name'),
            'group_order' => Yii::t('app', 'Order'),
        ];
    }
    public function getNProducts()
    {
        return $this->hasMany(NomenclatureProduct::class, ['group_id' => 'id']);
    }
    public function getChildGroups()
    {
        return $this->hasMany(GroupProduct::class, ['group_id' => 'id']);
    }
    public function getParentGroup()
    {
        return $this->hasOne(GroupProduct::class, ['id' => 'group_id']);
    }
}