<?php

namespace frontend\controllers;

use frontend\models\EquationForm;
use frontend\models\GameQuery;
use frontend\models\Gambler;
use frontend\models\Game;
use frontend\models\LoginForm;
use frontend\models\Math;
use Yii;
use yii\base\ErrorException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

class GameController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'frontend\models\MathCaptchaAction',
//                'captchaAction' => 'game/captcha',
                'fixedVerifyCode' => YII_ENV_TEST ? '42' : null,
            ],
        ];
    }

    public function actionChangeManner()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $manner = Yii::$app->request->post('manner') ?? 'async';

        $Gambler = Gambler::findOne(Yii::$app->user->identity->getId());
        $Gambler->manner = $manner;
        if (!$Gambler->save())
            throw new ErrorException(var_export($Gambler->getErrors(), true));
        return true;
    }


    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if (($model->load(Yii::$app->request->post()) && $model->login()) || !Yii::$app->user->isGuest) {
            return $this->redirect(Url::toRoute('game/equation'));
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionEquation()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $Gambler = Gambler::findOne(Yii::$app->user->identity->getId());
        $round = Game::find()->where(['gamblerId' => $Gambler->id])->max('round') ?? 1;
        $model = new EquationForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $correctIcon = Html::tag('i', ' correct', ['class' => 'fas fa-check']);
            $incorrectIcon = Html::tag('i', ' incorrect', ['class' => 'fas fa-times']);

            try {
                $Math = new Math();
                switch ($model->sign) {
                    case '+':
                        $Math = $Math->add($model->a, $model->b);
                        if ($model->answer == $Math->result)
                            Yii::$app->session->setFlash('success', "$model->a + $model->b = $model->answer $correctIcon");
                        else
                            Yii::$app->session->setFlash('error', "$model->a + $model->b = $model->answer $incorrectIcon");
                        break;
                    case '-':
                        $Math = $Math->sub($model->a, $model->b);
                        if ($model->answer == $Math->result)
                            Yii::$app->session->setFlash('success', "$model->a - $model->b = $model->answer $correctIcon");
                        else
                            Yii::$app->session->setFlash('error', "$model->a - $model->b = $model->answer $incorrectIcon");
                        break;
                }

                $Game = new Game(['gamblerId' => $Gambler->id, 'mathId' => $Math->id, 'round' => ++$round, 'answer' => $model->answer]);
                if (!$Game->save())
                    throw new ErrorException(var_export($Game->getErrors(), true));
                if ($round > Game::LIMIT)
                    return $this->redirect(Url::toRoute('game/summary'));

            } catch (ErrorException $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

            $model->setScenario('newRound');
            if (!$model->validate())
                Yii::$app->session->setFlash('error', $model->getErrors());

            $model->setScenario('answer');
            $limit = Game::LIMIT;

            return $this->render('equation', compact('model', 'limit', 'round'));
        }

        $model->setScenario('newRound');
        if (!$model->validate())
            Yii::$app->session->setFlash('error', $model->getErrors());

        $model->setScenario('answer');
        $model->async = $Gambler->getManner();
        $limit = Game::LIMIT;
        return $this->render('equation', compact('model', 'limit', 'round'));

    }


    /**
     * @return string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionSummary()
    {
        $gameQ = new  GameQuery(Game::className());
        $userId = !Yii::$app->user->isGuest ? Yii::$app->user->identity->getId() : false;
        $Gambler = Gambler::find()->where(['id' => $userId])->one();
        $cache = Yii::$app->cache;
        if ($userId) {
            if ($cache->exists('result'))
                $cache->delete('result');
            if ($cache->exists('result'))
                $cache->delete('result');

            $cache->delete('correctAnswers');
            $result = $gameQ->summaryResults($userId);
            $cache->set('result', $result, 3600);
            $correctAnswers = $gameQ->countCorrectAnswers($userId);
            $cache->set('correctAnswers', $correctAnswers, 3600);
            YII::$app->user->logout();
            $Gambler->delete();
        } else {
            $result = $cache['result'];
            $correctAnswers = $cache['correctAnswers'];
        }

        if (!$result)
            return $this->goHome();

        return $this->render('summary', compact('result', 'correctAnswers', 'cache'));
    }


//    public function afterAction($action, $result)
//    {
//        $result = parent::afterAction($action, $result);
//        // your custom code here
//        return $result;
//    }
//
//    public function beforeAction($action)
//    {
//        if ($action->id == 'summary')
//            $Gambler = new Gambler();
//        $Gambler->auth_key = Yii::$app->security->generateRandomString();
//        $Gambler->save();
//        Yii::$app->user->login($Gambler);
//        return true;
//    }


}
