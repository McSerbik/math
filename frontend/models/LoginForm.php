<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $verifyCode;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha','captchaAction'=>'game/captcha'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ['verifyCode' => 'Please enter answer'];
    }

    /**
     * @return Gambler|null
     * @throws \yii\base\Exception
     */
    public function login()
    {
        if (!$this->validate()) {
            return null;
        }

        $Gambler = new Gambler();
        $Gambler->authKey = Yii::$app->security->generateRandomString();
        $Gambler->save();
        Yii::$app->user->login($Gambler);
        return $Gambler ? true : null;
    }


}
