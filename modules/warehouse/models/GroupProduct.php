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
            [['name_hy', 'name_ru', 'name_en'], 'required'],
            [['name_hy', 'name_ru', 'name_en'], 'string', 'max' => 255],
            [['group_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name_hy' => Yii::t('app', 'Name(Armenian)'),
            'name_ru' => Yii::t('app', 'Name(Russian)'),
            'name_en' => Yii::t('app', 'Name(English)'),
            'group_id' => Yii::t('app', 'Parent Name'),
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
