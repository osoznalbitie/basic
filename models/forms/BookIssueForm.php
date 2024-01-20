<?php


namespace app\models\forms;


use app\models\Client;
use yii\base\Model;

class BookIssueForm extends Model
{
    public $passport;
    public $client_full_name;
    public $return_deadline;


    public function rules()
    {
        return [
            [['passport', 'return_deadline'], 'required'],
            ['passport', 'string', 'min' => 12, 'max' => 14],
            [['client_full_name'], 'required', 'when' => function ($model) {
                return !$model->isPassportExists($model->passport);
            }],
            [['return_deadline'], 'date', 'format' => 'php:Y-m-d'],
            ['return_deadline', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>', 'message' => 'Дата не может быть меньше сегодняшней.'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'passport' => 'Серия и номер паспорта',
            'client_full_name' => 'ФИО',
            'return_deadline' => 'Дата возврата',
        ];
    }
    /**
     * @throws \Exception
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Moscow'));
        $this->return_deadline = $currentDate->add(new \DateInterval('P14D'))->format('Y-m-d');

    }

    public function isPassportExists($passport): bool
    {
        if (empty($passport)) {
            return false;
        }
        $passport = str_replace(' ', '', $passport);
        return Client::find()->where(['passport' => $passport])->exists();
    }
}