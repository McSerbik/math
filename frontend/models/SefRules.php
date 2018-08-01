<?php
/**
 * Created by PhpStorm.
 * User: serbik
 * Date: 6/30/18
 * Time: 3:27 AM
 */

namespace frontend\models;


use Yii;
use yii\web\UrlRule;

class SefRules extends UrlRule
{
    public $connectionID = 'db';

    public function init()
    {
        if ($this->name === null) $this->name = __CLASS__;
    }

    public function createUrl($manager, $route, $params)
    {
        if ($route == 'game/summary')
            return 'summary';

        if ($route == 'game/equation')
            return 'equation';

        if ($route == 'game/captcha')
            return "/game/captcha?v=" . implode(' ', $params);

        return $route;
    }


    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        switch ($pathInfo) {
            case 'game/captcha':
                if (isset(Yii::$app->request->queryParams['v']))
                    return ['game/captcha', ['v' => Yii::$app->request->queryParams['v']]];
                break;
            case 'equation':
                return ['game/equation', []];
                break;
            case 'summary':
                if (!Yii::$app->user->isGuest) {
                    $round = Game::find()->where(['gamblerId' => Yii::$app->user->getId()])->max('round');
                    if ($round <= Game::LIMIT)
                        return ['game/equation', []];
                }
                return ['game/summary', []];
                break;
            case 'game/change-manner':
                if (!is_null(Yii::$app->request->post('manner')))
                    return ['game/change-manner', ['manner' => Yii::$app->request->post('manner')]];
                break;
        }

        if (Yii::$app->user->isGuest)
            return ['game/login', []];

        return [$pathInfo, []];
    }

}