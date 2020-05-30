<?php

use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $change_email_model app\models\ChangeEmailForm */
/* @var $change_password_model app\models\ChangePasswordForm */
/* @var $login_model app\models\LoginForm */

?>
<div class="account">
    <?php echo Tabs::widget([
        'items' => [
            [
                'label' => 'Change email',
                'content' => $this->render('change-email-form',
                    ['model' => $change_email_model]),
                'active' => true,
                'options' => [
                    'id' => 'change_email_form',
                    'class' => 'col-md-3'
                ]
            ],
            [
                'label' => 'Change password',
                'content' => $this->render('change-password-form',
                    ['model' => $change_password_model]),
                'options' => [
                    'id' => 'change_password_form',
                    'class' => 'col-md-3'
                ],
            ],
            [
                'label' => 'Login',
                'content' => $this->render('../site/login',
                    ['model' => $login_model]),
                'options' => [
                    'id' => 'login_form',
                ]
            ],
        ],
        'itemOptions' => [
            'style' => 'padding: 1em;',
        ],
    ]); ?>
</div>
