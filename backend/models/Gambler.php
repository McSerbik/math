<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "gambler".
 *
 * @property int $id
 * @property string $authKey
 * @property string $manner
 * @property string $createAt
 *
 * @property Game[] $games
 */
class Gambler extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gambler';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authKey'], 'required'],
            [['manner'], 'string'],
            [['createAt'], 'safe'],
            [['authKey'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'authKey' => 'Auth Key',
            'manner' => 'Manner',
            'createAt' => 'Create At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGames()
    {
        return $this->hasMany(Game::className(), ['gamblerId' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return GamblerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GamblerQuery(get_called_class());
    }
}
