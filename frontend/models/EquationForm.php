<?php

namespace frontend\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class EquationForm extends Model
{
    /**
     * @var int
     */
    const MAX_VAL = 1001;

    const MIN_VAL = 1;

    public $async = 1;
    /**
     * @var int
     */
    public $a;
    /**
     * @var int
     */
    /**
     * @var int
     */
    public $b;
    /**
     * @var string
     */
    public $sign;

    /**
     * @var int|double
     */
    public $answer;

    private $signs = ['+', '-'];

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'newRound' => ['a', 'b', 'sign'],
                'answer' => ['a', 'b', 'sign', 'answer']
            ]
        );
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['async', 'safe'],
            [['answer'], 'required', 'message' => "Answer's unable to be empty"],
            [['answer'], 'number'],
            ['a', 'default', 'value' => round(mt_rand(EquationForm::MIN_VAL, EquationForm::MAX_VAL) + (mt_rand() / mt_getrandmax()), 1)],
            ['b', 'default', 'value' => round(mt_rand(EquationForm::MIN_VAL, EquationForm::MAX_VAL) + (mt_rand() / mt_getrandmax()), 1)],

            [['a', 'b'], 'number', 'min' => EquationForm::MIN_VAL, 'max' => EquationForm::MAX_VAL],
            ['sign', 'default', 'value' => $this->signs[mt_rand(0, 1)]],
            ['sign', 'in', 'range' => $this->signs]
        ];

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'answer' => "Please tap Your answer",
        ];
    }

    public function beforeValidate()
    {
        if ($this->getScenario() == 'newRound')
            $this->a = $this->b = $this->answer = null;
        return true;
    }

    public function afterValidate()
    {
//        if ($this->getScenario() == 'newRound')
//            $this->answer = null;
    }

    /**
     * @param int $gamblerId
     * @return array
     */


}