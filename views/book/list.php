<?php



/* @var $this \yii\web\View */
/* @var $books \app\models\Book[]|array|\yii\db\ActiveRecord[] */
/* @var $pagination \yii\data\Pagination */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
$this->title = 'Список книг';
?>
    <h1><?= $this->title ?></h1>
    <div class="row align-items-end justify-content-between">
        <div class="filter-container col-lg">
            <label for="filter-input">Поиск</label>
            <input type="text" id="filter-input" placeholder="Поиск по названию">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="status-filter">
                <label class="form-check-label" for="status-filter">Только в наличии</label>
            </div>
            <button id="apply-filters-btn" class="btn btn-primary">Применить фильтры</button>
        </div>
        <a href="/web/index.php?r=book/add-book" class="col-sm-2"><button class="btn btn-primary">Добавить книгу</button></a>
    </div>
<div id="table-and-pagination">
</div>
<div class="modal fade" id="delete-book-modal" tabindex="-1" role="dialog" aria-labelledby="delete-book-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete-book-modal-label">Подтверждение удаления</h5>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите удалить книгу?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="close-modal" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirm-delete-book-button">Удалить</button>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile('@web/assets/book.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>