<?php

namespace app\models;

use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $confirmNewPassword;

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
            ['newPassword', 'validateNewPassword'],
            ['confirmNewPassword', 'validateConfirmNewPassword'],
        ];
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
                $this->addError($attribute, 'New password can`t be same as current password.');
            }
        }
    }

    /**
     * Validates the confirm password.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateConfirmNewPassword($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->confirmNewPassword !== $this->newPassword) {
                $this->addError($attribute, 'Confirmation password must be equal to the new email.');
            }
        }
    }
}
