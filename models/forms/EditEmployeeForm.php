<?php


namespace app\models\forms;


use app\models\User;
use yii\base\Model;

class EditEmployeeForm extends Model
{
    public $full_name;
    public $position_id;
    public $username;
    public $new_password;

    public function rules()
    {
        return [
            [['full_name', 'position_id', 'username'], 'required'],
            [['position_id'], 'integer'],
            [['full_name', 'username'], 'string', 'max' => 255],
            ['username', 'safe'],
            [['new_password'], 'string', 'max' => 30],
        ];
    }
    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
            'username' => 'Логин',
            'new_password' => 'Новый пароль',
            'position_id' => 'Должность',
        ];
    }

}