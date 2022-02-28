<?php

namespace app\modules\crm\models;

use Yii;

/**
 * This is the model class for table "crm_section".
 *
 * @property int $id
 * @property int|null $menu_id
 * @property string|null $name
 */
class CrmSection extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_section';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_id' => Yii::t('app', 'Menu ID'),
            'name' => Yii::t('app', 'Раздел'),
        ];
    }

    public function getFields() {
        return CrmCustomFields::find()->where(['section_id'=> $this->id])->all();
    }

}
