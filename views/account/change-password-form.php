<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$form = ActiveForm::begin([
    'id' => 'change_password_form',
]);
?>

<?= $form->field($model, 'password') ?>
<?= $form->field($model, 'newPassword')->label('New password') ?>
<?= $form->field($model, 'confirmNewPassword')->label('Confirm new password') ?>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>