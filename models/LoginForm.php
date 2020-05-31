<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            [['username', 'password'], 'validateUser'],
        ];
    }

    /**
     * Validates the user data.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateUser($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),
                $this->rememberMe ? 3600*24*30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return ActiveRecord|IdentityInterface|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * Create temporary authorization link to user account.
     *
     * @return string
     */
    public function createUserAuthLink() {
        $user = $this->getUser();
        $auth_key = uniqid("temp_link_");
        $auth_ref_url = Url::toRoute(
            ['account/index', 'auth_ref' => $auth_key], true
        );

        Yii::$app->db->createCommand()->delete('temp_auth_url', [
            'user_id' => $user->id,
        ])->execute();

        Yii::$app->db->createCommand()->insert('temp_auth_url', [
            'key' => $auth_key,
            'user_id' => $user->id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ])->execute();

        return $auth_ref_url;
    }

    /**
     * Delete temporary authorization link to user account.
     *
     */
    public function deleteAuthRef() {
        $user = $this->getUser();

        Yii::$app->db->createCommand()->delete('temp_auth_url', [
            'user_id' => $user->id,
        ])->execute();
    }

    /**
     * Send an account access link to user email.
     *
     * @return bool
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($this->username)
            ->setSubject('Account link')
            ->setHtmlBody(
                "<p>This is your temporary link to access your account: "
                . $this->createUserAuthLink() . "</p><br>" .
                "<p>Please, don't answer on this message!</p>"
            )->send();
    }

}
