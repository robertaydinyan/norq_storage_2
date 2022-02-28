<?php


namespace app\modules\warehouse\models;

/**
 * This is the model class for table "s_group_product".
 *
 * @property int $id
 * @property string images_path
 * @property int|null $product_id
 */
class ProductImagesPath extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 's_product_images_path';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['images_path'], 'required'],
            [['product_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'images_path' => 'Images Path',
            'product_id' => 'Product ID',
        ];
    }
}