<?php

namespace app\models;

use Yii;
use app\models\User;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property integer $user_id_from
 * @property integer $user_id_to
 * @property string $message
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $userIdFrom
 * @property User $userIdTo
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id_from', 'user_id_to'], 'required'],
            [['user_id_from', 'user_id_to', 'status'], 'integer'],
            [['message'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id_from'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id_from' => 'id']],
            [['user_id_to'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id_to' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_from' => 'User Id From',
            'user_id_to' => 'User Id To',
            'message' => 'Message',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFrom()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id_from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTo()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id_to']);
    }
}
