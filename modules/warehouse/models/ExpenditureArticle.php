<?php

namespace app\modules\warehouse\models;

use Yii;

/**
 * This is the model class for table "expenditure_article".
 *
 * @property int $id
 * @property int|null $name
 * @property int $isDeleted
 */
class ExpenditureArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'expenditure_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['isDeleted'], 'integer'],
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
        ];
    }
    public function attributeLabelsAll()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
