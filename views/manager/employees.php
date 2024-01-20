<?php



/* @var $this \yii\web\View */
/* @var $employees \app\models\User[]|array|\yii\db\ActiveRecord[] */

use app\models\Position;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Список сотрудников';
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <a href="/web/index.php?r=manager/add-employee" class="col-sm-2"><button class="btn btn-primary">Добавить сотрудника</button></a>

<?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider(['allModels' => $employees]),
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'ID',
        ],
        [
            'attribute' => 'full_name',
            'label' => 'ФИО',
        ],
        [
            'attribute' => 'position_id',
            'label' => 'Должность',
            'value' => function ($model) {
                return Position::getPositionName($model->position_id);
            },
        ],
        [
            'header' => 'Действия',
            'class' => ActionColumn::class,
            'template' => '{edit} {delete}',
            'buttons' => [
                'edit' => function ($url, $model, $key) {
                    return Html::a('<span class="btn btn-primary">Редактировать</span>', ['edit-employee', 'id' => $model['id']], [
                        'title' => 'Редактировать',
                        'data' => [
                            'method' => 'post',
                        ],
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="btn btn-danger">Удалить</span>', ['delete-employee', 'id' => $model['id']], [
                        'title' => 'Удалить',
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этого сотрудника?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
    ],
]); ?>
</div>