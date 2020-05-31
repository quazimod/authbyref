<?php

namespace app\models;

use yii\base\Model;

class ChangeEmailForm extends Model
{
    public $email;
    public $newEmail;
    public $confirmNewEmail;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'newEmail', 'confirmNewEmail'], 'required',
                'message' => 'Email cannot be blank.'],
            [['email', 'newEmail', 'confirmNewEmail'], 'email',
                'message' => 'Please enter a valid email.'],
            [['email', 'newEmail', 'confirmNewEmail'], 'string', 'max' => 256],
            [['email', 'newEmail', 'confirmNewEmail'], 'trim'],
            [['email', 'newEmail', 'newEmail'], 'default'],
            ['email', 'validateEmail'],
            ['newEmail', 'validateNewEmail'],
            ['confirmNewEmail', 'validateConfirmEmail'],
        ];
    }

    /**
     * Validates user current email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateEmail($attribute)
    {
        if (!$this->hasErrors()) {
            if ($this->email !== $this->_user->username) {
                $this->addError($attribute, 'Invalid current email.');
            }
        }
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
                $this->addError($attribute, 'New email can`t be equal as current email.');
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
                $this->addError($attribute, 'Confirmation email must be equal as the new email.');
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
     * Save new user email.
     *
     * @return bool
     */
    public function saveNewUserEmail()
    {
        if ($this->validate()) {
            $this->_user->username = $this->newEmail;
            $this->_user->save();
            return true;
        }

        return false;
    }
}
