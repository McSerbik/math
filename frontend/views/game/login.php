<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use frontend\models\MathCaptchaAction;

$this->title = 'Login';
?>
<div class="site-contact">
    <h1><?= 'Welcome' ?></h1>

    <p>

    </p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(),
                [
                    'captchaAction' => 'game/captcha',
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-5">{input}</div></div>',
                    'options' => ['autofocus' => 'autofocus', 'class' => 'form-control'],
                ])
            ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
