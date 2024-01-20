<?php


namespace app\models\forms;


use yii\base\Model;

class BookReturnForm extends Model
{
    public $book_id;
    public $state_id;

    public function rules()
    {
        return [
            [['book_id','state_id'], 'required'],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'state_id' => 'Состояние книги',
        ];
    }
}