<?php

namespace frontend\models;

use PDO;
use Yii;

/**
 * This is the ActiveQuery class for [[Game]].
 *
 * @see Game
 */
class GameQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Game[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Game|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function summaryResults($gamblerId)
    {
        $query = "SELECT
                  task,
        if(result = answer, CONCAT('<i class=\"fas fa-check\"> ', answer, ' correct </i>'),
CONCAT('<i class=\"fas fa-times\"> ', answer, '</i> <i class=\"fas\"> incorrect', ' (', result,') </i>')) AS answer
        FROM game
        JOIN math ON math.id = game.mathId
        WHERE gamblerId = $gamblerId";

        return YII::$app->db->createCommand($query)->queryAll();
    }

    public function countCorrectAnswers($gamblerId)
    {
        $command = Yii::$app->db->createCommand("CALL CountCorrectAnswer(:_userId,@count)");
        $command->bindParam(":_userId", $gamblerId, PDO::PARAM_INT);
        $command->execute();
        $count = Yii::$app->db->createCommand("select @count as count;")->queryScalar();

        return $count;
    }
}
