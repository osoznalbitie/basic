<?php



/* @var $this \yii\web\View */
/* @var $book \app\models\Book|null */
/* @var $model \app\models\forms\BookIssueForm  */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Выдача книги: ' . $book->title;
?>

<div class="book-issue-form">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'passport')->textInput(['maxlength' => 12, 'minlength' => 12]) ?>

    <?= $form->field($model, 'client_full_name')->textInput(['maxlength' => 255, 'disabled' => $model->isPassportExists($model->passport)]) ?>

    <?= $form->field($model, 'return_deadline')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Выдать книгу', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJsFile('@web/assets/bookIssue.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>