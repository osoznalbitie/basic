<?php


namespace app\models\forms;


use yii\base\Model;

class AddBookForm extends Model
{
    public $title;
    public $author_id;
    public $arrival_date;
    public $new_author_name;
    public function rules()
    {
        return [
            [['title', 'author_id', 'arrival_date'], 'required'],
            [['author_id'], 'integer'],
            [['arrival_date'], 'date', 'format' => 'php:Y-m-d'],
            [['new_author_name'], 'string'],
            ['arrival_date', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '<=', 'message' => 'Дата не может быть больше сегодняшней.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Название',
            'author_id' => 'Автор',
            'arrival_date' => 'Дата поставки',
            'new_author_name' => 'Новый автор',
        ];
    }

    public function __construct($config = [])
    {
        parent::__construct($config);

        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $this->arrival_date = $currentDate->format('Y-m-d');
    }
}