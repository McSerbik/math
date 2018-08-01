<?php

namespace frontend\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "math".
 * @property int $id
 * @property integer|double $a
 * @property int|double $b
 * @property string $task
 * @property int|double $result
 */
class Math extends \yii\db\ActiveRecord
{
    /**
     * @var int
     */
    public $a;
    /**
     * @var int
     */
    public $b;
    /**
     * @var string
     */
    public $operation;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'math';
    }

    public static function className()
    {
        return get_called_class();
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'operation' => ['a', 'b'],
                'result' => ['task', 'result'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task', 'result'], 'required'],
            [['task', 'operation'], 'string'],
            ['result', 'number'],
            [['a', 'b'], 'number'],
        ];
    }


    /**
     * @param null $a
     * @param null $b
     * @return $this|null
     * @throws \yii\base\ErrorException
     */
    public function add($a = null, $b = null)
    {
        if (!is_null($a)) {
            $this->a = $a;
        }
        if (!is_null($b)) {
            $this->b = $b;
        }
        $this->setScenario('operation');
        if (!$this->validate()) {
            throw new \yii\base\ErrorException(var_export($this->getErrors(), true));
        }
        $this->operation = '+';
        $this->result = $this->a + $this->b;

        if ($this->save()) {
            return $this;
//            return [$this->result, $this->id];
        }
        return null;
    }


    /**
     * @param null $a
     * @param null $b
     * @return $this|null
     * @throws \yii\base\ErrorException
     */
    public function sub($a = null, $b = null)
    {
        if (!is_null($a)) {
            $this->a = $a;
        }
        if (!is_null($b)) {
            $this->b = $b;
        }
        $this->setScenario('operation');
        if (!$this->validate()) {
            throw new \yii\base\ErrorException(var_export($this->getErrors(), true));
        }
        $this->operation = '-';
        $this->result = $this->a - $this->b;

        if ($this->save()) {
            return $this;

//            return [$this->result, $this->id];
        }
        return null;
    }

    /**
     * Making preparements before save to db
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setScenario('result');
            $this->task = $this->a . $this->operation . $this->b;
            return true;
        }
        return false;
    }

}
