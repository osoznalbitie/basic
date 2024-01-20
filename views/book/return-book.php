<?php



/* @var $this \yii\web\View */
/* @var $book \app\models\Book|mixed */
/* @var $model \app\models\forms\BookReturnForm */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Вернуть книгу';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="book-return-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'book_id')->hiddenInput(['value' => $book->id])->label(false) ?>

    <?= $form->field($model, 'state_id')->dropDownList(
        ArrayHelper::map(\app\models\BookState::find()->all(), 'id', 'state_name')
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Вернуть', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>