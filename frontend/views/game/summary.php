<?php

use frontend\models\Game;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$provider = new ArrayDataProvider([
    'allModels' => $result
]);

$tCount = Game::LIMIT;
$incorrectAnswer = $tCount - $correctAnswers;

echo GridView::widget([
    'dataProvider' => $provider,
    'showFooter' => true,
    'layout' => "{items}\n{pager}",
    'columns' => [
        [
            'label' => 'Task',
            'format' => 'html',
            'content' => function ($data) {
                return Html::tag('i', "\t" . $data['task'] . " = ?", ['class' => 'fas fa-thumbtack']);
            },
            'footer' => Html::tag('i', " total count of rounds : $tCount", ['class' => 'fas fa-bullhorn'])
        ],
        [
            'attribute' => 'answer',
            'format' => 'html',
            'footer' => Html::tag('i', " correct ($correctAnswers) " .
                Html::tag('i', " incorrect ($incorrectAnswer) ", ['class' => 'fa-times']),
                ['class' => 'fas fa-check'])

        ]
    ]
]);

