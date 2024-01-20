<?php



/* @var $this \yii\web\View */
/* @var $clients \app\models\Client[]|array|\yii\db\ActiveRecord[] */
/* @var $pagination \yii\data\Pagination */

$this->title = 'Клиенты';
?>
    <h1><?= $this->title ?></h1>
<div class="filter-container">
    <input type="text" id="filter-input" placeholder="Поиск по ФИО">
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="status-filter">
        <label class="form-check-label" for="status-filter">Только с книгами</label>
    </div>
    <button id="apply-filters-btn" class="btn btn-primary">Применить фильтры</button>
</div>
<div id="table-and-pagination">
</div>
<?php
$this->registerJsFile('@web/assets/client.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>