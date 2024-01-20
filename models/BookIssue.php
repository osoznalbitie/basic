<?php


namespace app\models;


use app\models\forms\BookIssueForm;
use Yii;
use yii\db\ActiveRecord;

class BookIssue extends ActiveRecord
{
    public static function tableName()
    {
        return 'book_issue';
    }

    public function rules()
    {
        return [
            [['issue_date', 'book_id', 'client_id','employee_id', 'return_deadline'], 'required'],
            [['issue_date', 'return_deadline'], 'date', 'format' => 'php:Y-m-d'],
            [['book_id', 'employee_id', 'client_id'], 'integer'],
        ];
    }

    /**
     * Сохранение записи о выдаче
     *
     * @param Book $book
     * @param BookIssueForm $model
     * @return bool
     */
    public static function issueBook(Book $book, BookIssueForm $model)
    {
        $model->passport = str_replace(' ', '', $model->passport);

        $client = Client::findOne(['passport' => $model->passport]);

        if ($client === null) {
            Client::saveClient($model->passport, $model->client_full_name);
            $client = Client::findOne(['passport' => $model->passport]);
        }

        $bookIssue = new self();
        $bookIssue->client_id = $client->id;
        $bookIssue->issue_date = date('Y-m-d');
        $bookIssue->book_id = $book->id;
        $bookIssue->employee_id = Yii::$app->user->identity->id;
        $bookIssue->return_deadline = $model->return_deadline;

        if ($bookIssue->validate() && $bookIssue->save()) {
            $book->status = 0;
            $book->save();
            return true;
        }

        return false;
    }
}