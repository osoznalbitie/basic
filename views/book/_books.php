<?php



/* @var $this \yii\web\View */
/* @var $books \app\models\Book[]|array|\yii\db\ActiveRecord[] */
/* @var $pagination \yii\data\Pagination */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div id="table-and-pagination">

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Название</th>
            <th>Автор</th>
            <th>Артикул</th>
            <th>Дата поступления</th>
            <th>Действия</th>
            <th>Удалить</th>
        </tr>
        </thead>
        <tbody id="table-body">
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?= Html::encode("{$book->title}") ?></td>
                <td><?= Html::encode("{$book->author->author_name}") ?></td>
                <td><?= Html::encode("{$book->article}") ?></td>
                <td><?= Html::encode("{$book->arrival_date}") ?></td>
                <td class="row-cols-sm-2 justify-content-between">
                    <a href="<?= Url::to(['/book/info', 'bookArticle' => $book->article]) ?>" class="btn btn-primary col-sm-5">Информация</a>
                    <?php if ($book->status): ?>
                        <a href="<?= Url::to(['/book/issue-book', 'bookId' => $book->id]) ?>" class="btn btn-primary col-sm-3">Выдать</a>
                    <?php else: ?>
                        <a href="<?= Url::to(['/book/return-book', 'bookId' => $book->id]) ?>" class="btn btn-danger col-sm-3">Вернуть</a>
                        <b><?='Срок: ' . $book->getDeadline() ?></b>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?= Url::to(['book/delete-book', 'bookId' => $book->id]) ?>"
                       class="btn btn-danger delete-book-link"
                       data-toggle="modal"
                       data-target="#delete-book-modal"
                       data-id="<?= $book->id ?>">
                        Удалить
                    </a>
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
</div>
