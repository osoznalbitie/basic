<?php


namespace app\models\forms;


use app\models\User;
use yii\base\Model;

class addEmployeeForm extends Model
{
    public $full_name;
    public $position_id;
    public $username;
    public $password_hash;

    public function rules()
    {
        return [
            [['full_name', 'position_id', 'username', 'password_hash'], 'required'],
            [['position_id'], 'integer'],
            [['full_name', 'username'], 'string', 'max' => 255],
            ['username', 'validateUsername'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
            'position_id' => 'Должность',
            'username' => 'Имя пользователя',
            'password_hash' => 'Пароль',
        ];
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $existingEmployee = User::find()->where(['username' => $this->$attribute])->one();

            if ($existingEmployee !== null) {
                $this->addError($attribute, 'Пользователь с таким именем пользователя уже существует.');
            }
        }
    }
}