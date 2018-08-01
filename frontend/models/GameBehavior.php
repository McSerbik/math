<?php
/**
 * Created by PhpStorm.
 * User: serbik
 * Date: 6/14/18
 * Time: 5:12 AM
 */

namespace frontend\models;


use yii\base\Behavior;

class GameBehavior extends Behavior
{
    public function events()
    {
        return [
            SiteController::EVENT_AFTER_ACTION => 'onEventLog',
        ];
    }

    public function onEventLog($event)
    {
        $log = new QueriesLog();
        $log->datetime = $event->datetime;
        $log->user = $event->user;
        $log->url = $event->url;
        $log->sql_query = $event->sql_query;
        $log->time = $event->time;
        $log->save(true);
    }

}