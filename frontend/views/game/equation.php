<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

$a = null;
switch ($model->sign) {
    case '+':
        $a = $model->a + $model->b;
        break;
    case '-':
        $a = $model->a - $model->b;
        break;
}

Pjax::begin(['id' => 'form']);

//if ($model->async)
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    $status = null;
    $info = null;
    switch ($key) {
        case 'success':
            $status = 'correct';
            $info = 'alert-success alert fade in';
            break;
        case 'error':
            $status = 'incorrect';
            $info = 'alert-danger alert fade in';
    }
    echo Html::tag('div', Html::button('×', ['class' => 'close', 'data-dismiss' => 'alert'
        ]) . $message,
        ['class' => "$info"]);
// , 'aria-hidden' => 'true'
}
echo Html::tag('h2', "Round $round of $limit");
echo Html::tag('h2', "$model->a $model->sign $model->b = ? $a");

$form = ActiveForm::begin(['id' => 'equationForm', 'action' => ['game/equation'], 'options' => ['data-pjax' => $model->async ? true : false]]);

echo $form->field($model, 'async')->checkbox(['id' => 'Async']);
echo $form->field($model, 'a')->textInput(['readonly' => true, 'style' => 'display:none'])->label(false);
echo $form->field($model, 'sign')->textInput(['readonly' => true, 'style' => 'display:none'])->label(false);
echo $form->field($model, 'b')->textInput(['readonly' => true, 'style' => 'display:none'])->label(false);
echo $form->field($model, 'answer', ['template' => "<h2>{label}</h2>{input}\n{error}"])->textInput();

echo Html::submitButton("Submit", ['class' => 'btn btn-success']);

ActiveForm::end();
yii\widgets\Pjax::end();
Html::endTag('div');






