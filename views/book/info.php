<?php



/* @var $this \yii\web\View */
/* @var $book \app\models\Book|mixed */
/* @var $operations array */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $book->title;
?>

<div class="book-info">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $book,
        'attributes' => [
            [
                'label' => 'Название',
                'value' => $book->title,
            ],
            [
                'label' => 'Артикул',
                'value' => $book->article,
            ],
            [
                'label' => 'Дата поступления',
                'value' => $book->arrival_date,
            ],
            [
                'label' => 'Автор',
                'value' => $book->author->author_name,
            ],
            [
                'label' => 'В наличии',
                'value' => $book->status ? 'Да' : 'Нет',
            ],
        ],
    ]) ?>

    <h2>Операции</h2>

    <table class="table">
        <thead>
        <tr>
            <th>Клиент</th>
            <th>Сотрудник</th>
            <th>Дата</th>
            <th>Тип операции</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($operations as $operation): ?>
            <tr>
                <td><?= Html::encode("{$operation->getClient()->full_name}") ?></td>
                <td><?= $operation->getEmployee() ? $operation->getEmployee()->full_name : '<b class="link-danger">Удаленный сотрудник</b>' ?></td>
                <td><?= Html::encode("{$operation->operationDate}") ?></td>
                <td><?= Html::encode($operation->operationType == 1 ? 'Выдача' : 'Возврат (' . $operation->getStateName() .')') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

</div>