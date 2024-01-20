<?php

/* @var $this \yii\web\View */
/* @var $clients \app\models\Client[]|array|\yii\db\ActiveRecord[] */
/* @var $pagination \yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\LinkPager;

?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ФИО</th>
            <th>Серия и номер паспорта</th>
            <th>Выданные книги</th>
        </tr>
        </thead>
        <tbody id="table-body">
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= Html::encode("{$client->full_name}") ?></td>
                <td><?=$client->passport; ?>
                <td>
                    <?php foreach ($client->getBooks() as $book): ?>
                        <?= Html::encode("{$book->title} (Срок возврата: {$book->getDeadline()})") ?><br>
                    <?php endforeach; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <nav aria-label="...">
        <?= LinkPager::widget([
            'pagination' => $pagination,
            'options' => ['class' => 'pagination'],
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'pageCssClass' => 'page-item',
            'activePageCssClass'=> 'active',
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'span', 'class' => 'page-link disabled'],
        ]) ?>
    </nav>