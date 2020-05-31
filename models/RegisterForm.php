<?php


namespace app\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $email;
    public $password;
    public $confirmPassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password', 'confirmPassword'], 'required'],
            [['email', 'password', 'confirmPassword'], 'trim'],
            [['email', 'password', 'confirmPassword'], 'default'],
            ['email', 'email', 'message' => 'Please enter a valid email.'],
            [['email','password', 'confirmPassword'], 'string', 'max' => 256],
            ['email', 'validateUsername'],
            ['password', 'validatePassword']
        ];
    }

    public function validateUsername($attribute)
    {
        if (!$this->hasErrors()) {
            if (User::findByUsername($this->email)) {
                $this->addError($attribute, 'User with that email already exists.');
            }
        }
    }

    /**
     * Check that password and confirm password are equal.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->confirmPassword) {
                $this->addError($attribute, 'Confirmation password is not equal.');
            }
        }
    }

    /**
     * Create and save new user to db
     *
     * @return User|null
     */
    public function createNewUser()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->email;
            $user->password_hash = Yii::$app->getSecurity()->
                generatePasswordHash($this->password);
            $user->save();

            return $user;
        }

        return null;
    }
}