<?php

use yii\bootstrap\Alert;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $change_email_model app\models\ChangeEmailForm */
/* @var $change_password_model app\models\ChangePasswordForm */
/* @var $login_model app\models\LoginForm */

if ($message = Yii::$app->session->getFlash('message')) {
    echo Alert::widget([
        'options' => ['class' => 'alert-success'],
        'body' => $message,
    ]);
}

$active_page = Yii::$app->session->getFlash('active_page');
$active_page = $active_page? $active_page : 'change_email';
?>
<div class="account">

    <?php echo Tabs::widget([
        'items' => [
            [
                'label' => 'Change email',
                'content' => $this->render('change-email-form',
                    ['model' => $change_email_model]
                ),
                'options' => [
                    'class' => 'col-md-3',
                    'id' => 'change_email'
                ],
                'active' => $active_page === 'change_email'
            ],
            [
                'label' => 'Change password',
                'content' => $this->render('change-password-form',
                    ['model' => $change_password_model]
                ),
                'options' => [
                    'class' => 'col-md-3',
                    'id' => 'change_password'
                ],
                'active' => $active_page === 'change_password'
            ],
            [
                'label' => 'Login',
                'content' => $this->render('../site/login',
                    [
                        'model' => $login_model,
                        'message' => ''
                    ]
                ),
                'options' => [
                    'id' => 'login_form',
                ],
                'active' => $active_page === 'login'
            ],
        ],
        'itemOptions' => [
            'style' => 'padding: 1em;',
        ],
    ]); ?>
</div>
