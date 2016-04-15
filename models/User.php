<?php

namespace app\models;

use Yii;
use app\models\Message;
use app\models\Notification;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property integer $role
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    const ROLE_USER = 2;
    const ROLE_ADMIN = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['role', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentMessages()
    {
        return $this->hasMany(Message::className(), ['user_id_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedMessages()
    {
        return $this->hasMany(Message::className(), ['user_id_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSentNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_id_from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedNotifications()
    {
        return $this->hasMany(Notification::className(), ['user_id_to' => 'id']);
    }


    /*----------  Implementation of IdentityInterface  ----------*/

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = static::findOne($id);
        return !empty($user) ? $user : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; # No implementation yet
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return false; # No implmentation yet
    }


    /*----------  Custom Implementations  ----------*/


    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()
                        ->validatePassword($password, $this->password);
    }

    /**
     * Notify user about a new message
     *
     * @param Message $message create notification for this message
     * @return boolean if notification created successfully
     */
    public function notify($message)
    {
        $notification = new Notification;
        $notification->user_id_from = $message->user_id_from;
        $notification->user_id_to = $message->user_id_to;
        $notification->content = 'You have received a new message.';
        if ($notification->validate()) {
            $notification->save();
            return true;
        }
        return false;
    }


    /**
     * Mark notifications as read
     *
     * @return boolean if notification read successfully
     */
    public function readNotification()
    {
        $updated = Notification::updateAll(['read' => 1], "user_id_from = {$this->id}");
        return $updated > 0;
    }
}
