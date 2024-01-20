<?php



/* @var $this \yii\web\View */
/* @var $operations array */
/* @var $pagination \yii\data\Pagination */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = 'История операций';
?>
<h1><?= $this->title ?></h1>
<div id="table-and-pagination">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Клиент</th>
            <th>Название</th>
            <th>Сотрудник</th>
            <th>Дата</th>
            <th>Тип операции</th>
        </tr>
        </thead>
        <tbody id="table-body">
        <?php foreach ($operations as $operation): ?>
            <tr>
                <td><?= Html::encode("{$operation->getClient()->full_name}") ?></td>
                <td><?= Html::encode("{$operation->getBook()->title}") ?></td>
                <td><?= $operation->getEmployee() ? $operation->getEmployee()->full_name : '<b class="link-danger">Удаленный сотрудник</b>' ?></td>
                <td><?= Html::encode("{$operation->operationDate}") ?></td>
                <td><?= Html::encode($operation->operationType == 1 ? 'Выдача' : 'Возврат (' . $operation->getStateName() .')') ?></td>

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