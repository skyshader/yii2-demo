<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'Messaging App';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Users</h2>

                <hr>

                <div class="list-group">
                    <?php
                    if (!empty($users)) :
                        foreach ($users as $list_user) :
                            ?>
                                <a href="<?= Url::to(['user/chat', 'id' => $list_user->id]) ?>" class="list-group-item <?= $user->id === $list_user->id ? 'active' : '' ?>">
                                    <span class="badge">0</span>
                                    <?= $list_user->name; ?>
                                </a>
                            <?php
                        endforeach;
                    endif
                    ?>
                </div>
            </div>

            <div class="col-lg-8">
                <h2>Chat with <?= $user->name; ?></h2>

                <hr>

                <div class="panel panel-default">
                    <div class="panel-body message-container">

                        <?=
                            $this->render('message', [
                                'model' => $message,
                                'forUser' => $user,
                            ])
                        ?>

                        <hr>

                        <div class="messages-list">
                            <?php
                            if (!empty($messages)) :
                                foreach ($messages as $message) :
                                    ?>
                                        <div class="media col-md-11 well well-sm <?= (Yii::$app->user->identity->id === $message->userFrom->id) ? 'pull-right text-right' : '' ?>">
                                            <div class="media-body">
                                                <h4 class="media-heading">
                                                    <?= (Yii::$app->user->identity->id === $message->userFrom->id) ? 'You' : $message->userFrom->name ?>
                                                </h4>
                                                <span class="message"><?= $message->message ?></span>
                                            </div>
                                        </div>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>

                    <div class="dummy-message hide">
                        <div class="media col-md-11 well well-sm pull-right text-right">
                            <div class="media-body">
                                <h4 class="media-heading">
                                    You
                                </h4>
                                <span class="message"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
