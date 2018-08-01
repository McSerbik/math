<?php

namespace frontend\models;

/**
 * This is the model class for table "game".
 *
 * @property int $id
 * @property int $gamblerId
 * @property int $mathId
 * @property int $round
 * @property int $answer
 *
 * @property Gambler $gambler
 * @property Math $task
 */
class Game extends \yii\db\ActiveRecord
{
    const LIMIT = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'game';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gamblerId', 'mathId', 'answer'], 'required'],
            [['gamblerId', 'mathId'], 'integer'],
            ['answer', 'number'],
            ['round', 'integer'],
            [['mathId'], 'unique'],
            [['gamblerId'], 'exist', 'skipOnError' => true, 'targetClass' => Gambler::className(), 'targetAttribute' => ['gamblerId' => 'id']],
            [['mathId'], 'exist', 'skipOnError' => true, 'targetClass' => Math::className(), 'targetAttribute' => ['mathId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gamblerId' => 'Gambler ID',
            'mathId' => 'Task ID',
            'answer' => 'Answer',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGambler()
    {
        return $this->hasOne(Gambler::className(), ['id' => 'gamblerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Math::className(), ['id' => 'mathId']);
    }

    /**
     * {@inheritdoc}
     * @return GameQuery
     */
    public static function find()
    {
        return new GameQuery(get_called_class());
    }
}
