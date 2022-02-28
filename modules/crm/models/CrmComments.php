<?php

namespace app\modules\crm\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "crm_comments".
 *
 * @property int $id
 * @property int|null $contact_id
 * @property int|null $company_id
 * @property int|null $crm_type
 * @property string $comment
 * @property string|null $create_at
 * @property string|null $update_at
 */
class CrmComments extends \yii\db\ActiveRecord
{

    /**
     * CRM comment types
     */
    const LEAD_COMMENT = 1;
    const DEAL_COMMENT = 2;
    const CONTACT_COMMENT = 3;
    const COMPANY_COMMENT = 4;
    const PRODUCT_COMMENT = 5;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'crm_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['contact_id', 'company_id', 'crm_type'], 'integer'],
            [['comment'], 'required'],
            [['comment'], 'string'],
            [['create_at', 'update_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'contact_id' => Yii::t('app', 'Contact ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'crm_type' => Yii::t('app', 'Crm Type'),
            'comment' => Yii::t('app', 'Comment'),
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }

    /**
     * @return array|array[]
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    self::EVENT_BEFORE_UPDATE => 'update_at',
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param $id
     * @param false $isCompany
     * @param null $limit
     * @param int $start
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getComment($id, $isCompany = false, $limit = null, $start = 0)
    {
        $comments = self::find();
        if ($isCompany === true) {
            $comments->where(['company_id' => $id]);
        } else {
            $comments->where(['contact_id' => $id]);
        }

        $comments->orderBy(['id' => SORT_DESC]);

        if (!is_null($limit)) {
            $comments->offset($start)->limit($limit);
        }

        return $comments->all();
    }

    /**
     * @param $id
     * @return CrmComments|null
     */
    public function getCommentById($id)
    {
        return self::findOne($id);
    }
}
