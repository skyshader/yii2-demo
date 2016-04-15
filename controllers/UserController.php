<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Message;
use app\components\AccessRule;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

class UserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'only' => ['home', 'create', 'chat', 'message'],
                'rules' => [
                    [
                        'actions' => ['home', 'chat', 'message'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_USER,
                            User::ROLE_ADMIN
                        ],
                        'denyCallback' => function ($rule, $action) {
                            return $this->goHome();
                        }
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [
                            User::ROLE_ADMIN
                        ],
                        'denyCallback' => function ($rule, $action) {
                            throw new \Exception('You are not allowed to access this page');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['get', 'post'],
                    'chat' => ['get'],
                    'message' => ['post'],
                ],
            ],
        ];
    }

    
    public function actionHome()
    {
        $current_user = Yii::$app->user->identity;
        $first_user = User::find()->where(['status' => 1])
                             ->andWhere(['<>', 'id', $current_user->id])
                             ->one();

        return $this->redirect('/user/chat/' . $first_user->id, 302);
    }


    public function actionChat($id)
    {
        $current_user = Yii::$app->user->identity;
        $users = User::find()->where(['status' => 1])
                             ->andWhere(['<>', 'id', $current_user->id])
                             ->all();

        $message = new Message;

        $user = $messages = null;

        if (!empty($users) && $current_user->id != $id) {
            foreach ($users as $object) {
                if ($id == $object->id) {
                    $user = $object;
                    $messages = Message::find()
                        ->with('userFrom')
                        ->where(['status' => 1])
                        ->andWhere("user_id_from IN ({$user->id}, {$current_user->id})")
                        ->andWhere("user_id_to IN ({$user->id}, {$current_user->id})")
                        ->orderBy('created_at DESC')
                        ->all();
                    break;
                }
            }
        }

        return $this->render('chat', [
            'users' => $users,
            'user' => $user,
            'message' => $message,
            'messages' => $messages
        ]);
    }


    public function actionMessage()
    {
        if (!Yii::$app->request->isAjax) {
            echo json_encode([
                'success' => false,
                'message' => 'Method denied!'
            ]);
            die;
        }

        if (!isset($_REQUEST['for_user']) || !isset($_REQUEST['message'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
            die;
        }

        $for = $_REQUEST['for_user'];
        $content = $_REQUEST['message'];
        $current_user = Yii::$app->user->identity;

        $for_user = User::findOne($for);
        if (empty($for_user)) {
            echo json_encode([
                'success' => false,
                'message' => 'The requested user does not exists!'
            ]);
            die;
        }

        $message = new Message;
        $message->user_id_to = $for;
        $message->message = $content;
        $message->user_id_from = $current_user->id;
        if ($message->validate()) {
            $message->save();
            $for_user->notify($message);
            
            echo json_encode([
                'success' => true,
                'message' => 'Message sent successfully!'
            ]);
            die;
        }

        echo json_encode([
            'success' => false,
            'message' => 'Something went wrong!'
        ]);
        die;
    }


    public function actionCreate()
    {
        $model = new User;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                return $this->redirect('/user/home', 302);
            }
            return $this->goBack();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
}
