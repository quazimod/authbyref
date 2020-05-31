<?php

namespace app\controllers;

use app\models\ChangeEmailForm;
use app\models\ChangePasswordForm;
use app\models\LoginForm;
use app\models\User;
use Exception;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;

class AccountController extends Controller
{
    public function actionIndex()
    {
        try {
            $request = Yii::$app->request;
            $change_email_model = new ChangeEmailForm();
            $change_password_model = new ChangePasswordForm();
            $login_model = new LoginForm();

            if ($auth_key = $request->get('auth_ref')) {
                if (!$ref = User::getAuthRef($auth_key)) {
                    throw new UnauthorizedHttpException('Auth key not found.');
                } elseif (!$user = User::findOne($ref['user_id'])) {
                    throw new UnauthorizedHttpException('User not found.');
                }

                $change_email_model->setUser($user);
                $change_password_model->setUser($user);

                if ($change_email_model->load($request->post())) {
                    if ($change_email_model->saveNewUserEmail()) {
                        Yii::$app->session->setFlash('message', 'Email was success changed!');
                        $change_email_model->email = $change_email_model->newEmail;
                        $change_email_model->newEmail = '';
                        $change_email_model->confirmNewEmail = '';
                    }

                    Yii::$app->session->setFlash('active_page', 'change_email');
                } elseif($change_password_model->load($request->post())) {
                    if ($change_password_model->saveNewUserPassword()) {
                        Yii::$app->session->setFlash('message', 'Password was success changed!');
                        $change_password_model->password = '';
                        $change_password_model->newPassword = '';
                        $change_password_model->confirmNewPassword = '';
                    }

                    Yii::$app->session->setFlash('active_page', 'change_password');
                } elseif($login_model->load($request->post())) {
                    if ($login_model->login()) {
                        $login_model->deleteAuthRef();
                        return $this->goBack();
                    }

                    Yii::$app->session->setFlash('active_page', 'login');
                }
            } else {
                throw new BadRequestHttpException('Auth key is not valid.');
            }
        } catch(Exception $e) {
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = ['message' => 'Authorization failed: ' . $e->getMessage()];
        }

        return $this->render('index', [
            'change_email_model' => $change_email_model,
            'change_password_model' => $change_password_model,
            'login_model' => $login_model
        ]);
    }

}
