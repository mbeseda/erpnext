<?php

namespace backend\models;

use Yii;
use backend\ErpGroupModel;

/**
 * This is the model class for table "address_type".
 *
 * @property string $id
 * @property string $title
 * @property string $type
 * @property integer $status
 * @property string $group_id
 * @property integer $is_group
 *
 * @property AddressType $group
 * @property AddressType[] $addressTypes
 */
class AddressType extends \yii\db\ActiveRecord
{
    use ErpGroupModel;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string'],
            [['status', 'group_id', 'is_group'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'required'],
            [['title'], 'unique'],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => AddressType::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'type' => 'Type',
            'status' => 'Status',
            'group_id' => 'Group ID',
            'is_group' => 'Is Group',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AddressType::className(), ['id' => 'group_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressTypes()
    {
        return $this->hasMany(AddressType::className(), ['group_id' => 'id']);
    }

}
