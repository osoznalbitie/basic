<?php


namespace app\models;


use Yii;
use yii\db\ActiveRecord;

class BookReturn extends ActiveRecord
{

    public static function tableName()
    {
        return 'book_return';
    }


    /**
     * Сохранение записи о возврате
     *
     * @param $book
     * @param $stateId
     * @return bool
     */
    public static function returnBook($book, $stateId)
    {
        $latestBookIssue = BookIssue::find()
            ->where(['book_id' => $book->id])
            ->orderBy('issue_date DESC')
            ->one();

        if ($latestBookIssue) {
            $returnedBook = new self();
            $returnedBook->book_id = $book->id;
            $returnedBook->book_issue_id = $latestBookIssue->id;
            $returnedBook->client_id = $latestBookIssue->client_id;
            $returnedBook->employee_id = Yii::$app->user->identity->id;
            $returnedBook->return_date = date('Y-m-d');
            $returnedBook->state_id = $stateId;

            if ($returnedBook->validate() && $returnedBook->save()) {
                $book->status = 1;
                $book->save();
                return true;
            }
        }

        return false;
    }

}