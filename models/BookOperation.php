<?php


namespace app\models;


use yii\base\Model;

class BookOperation extends Model
{
    public $bookId;
    public $clientId;
    public $employeeId;
    public $operationDate;
    public $operationType;
    public $state_id;

    public function __construct($bookId, $clientId, $employeeId, $operationDate, $operationType, $state_id = null)
    {
        parent::__construct();
        $this->bookId = $bookId;
        $this->clientId = $clientId;
        $this->employeeId = $employeeId;
        $this->operationDate = $operationDate;
        $this->operationType = $operationType;
        $this->state_id = $state_id;
    }
    public function getClient()
    {
        return Client::findOne($this->clientId);
    }
    public function getBook()
    {
        return Book::findOne($this->bookId);
    }
    public function getEmployee()
    {
        return User::findOne($this->employeeId);
    }
    public function getStateName()
    {
        return State::findOne($this->state_id)->state_name;
    }
}
