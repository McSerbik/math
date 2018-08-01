<?php
/**
 * Created by PhpStorm.
 * User: serbik
 * Date: 6/14/18
 * Time: 5:07 AM
 */

namespace frontend\models;


use yii\base\Event;

class GameEvent extends Event
{
    public $userId;
    public $result;
    public $correctAnswers;

}