<?php

namespace app\models;

use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $confirmNewPassword;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'newPassword', 'confirmNewPassword'], 'required',
                'message' => 'Password cannot be blank.'],
            [['password', 'newPassword', 'confirmNewPassword'], 'trim'],
            [['password', 'newPassword', 'confirmNewPassword'], 'default'],
            [['password', 'newPassword', 'confirmNewPassword'], 'string', 'max' => 256],
            ['password', 'validatePassword'],
            ['newPassword', 'validateNewPassword'],
            ['confirmNewPassword', 'validateConfirmPassword'],
        ];
    }

    /**
     * Validates user current password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->getUser()->password !== $this->password) {
                $this->addError($attribute, 'Wrong current password.');
            }
        }
    }

    /**
     * Validates the new password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateNewPassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->password === $this->newPassword) {
                $this->addError($attribute, 'New password can`t be equal as current password.');
            }
        }
    }

    /**
     * Validates the confirm password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateConfirmPassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->confirmNewPassword !== $this->newPassword) {
                $this->addError($attribute, 'Confirmation password must be equal as new password.');
            }
        }
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->_user = $user;
    }

    /**
     * Save new user password.
     *
     * @return bool
     */
    public function saveNewUserPassword()
    {
        if ($this->validate()) {
            $this->_user->password = $this->newPassword;
            $this->_user->save();
            return true;
        }

        return false;
    }
}
