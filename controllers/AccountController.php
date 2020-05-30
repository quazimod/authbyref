<?php

namespace app\controllers;

use app\models\ChangeEmailForm;
use app\models\ChangePasswordForm;
use app\models\LoginForm;
use yii\web\Controller;

class AccountController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'change_email_model' => new ChangeEmailForm(),
            'change_password_model' => new ChangePasswordForm(),
            'login_model' => new LoginForm(),
        ]);
    }
}
