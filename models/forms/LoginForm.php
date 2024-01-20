<?php

namespace app\models\forms;

use app\models\User;
use Yii;
use yii\base\Model;


/**
 *
 * @property-read mixed $user
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function login() {

        if ($this->validate()) {

            $user = User::findByUsername($this->username);
            if ($user === null) {
                return false;
            }

            if (!Yii::$app->security->validatePassword($this->password, $user->password_hash)) {
                return false;
            }

            Yii::$app->user->login($user);
            return true;
        }

        return false;
    }

    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный логин или пароль.');
            }
        }
    }
    function password_verify (string $password, string $hash): bool {
        $salt = substr($hash, 0, 22);
        return crypt($password, $salt) === $hash;
    }
}