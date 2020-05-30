<?php

namespace app\models;

use yii\base\Model;

class ChangeEmailForm extends Model
{
    public $email;
    public $newEmail;
    public $confirmNewEmail;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'newEmail', 'confirmNewEmail'], 'required',
                'message' => 'Email cannot be blank.'],
            [['email', 'newEmail', 'confirmNewEmail'], 'trim'],
            [['email', 'newEmail', 'confirmNewEmail'], 'default'],
            [['email', 'newEmail', 'confirmNewEmail'], 'email',
                'message' => 'Please enter a valid email.'],
            [['email', 'newEmail', 'confirmNewEmail'], 'string', 'max' => 256],
            ['newEmail', 'validateNewEmail'],
            ['confirmNewEmail', 'validateConfirmEmail'],
        ];
    }

    /**
     * Validates the new email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateNewEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->email === $this->newEmail) {
                $this->addError($attribute, 'New email can`t be same as current email.');
            }
        }
    }

    /**
     * Validates the confirm email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateConfirmEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->confirmNewEmail !== $this->newEmail) {
                $this->addError($attribute, 'Confirmation email must be equal to the new email.');
            }
        }
    }
}
