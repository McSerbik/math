<?php

use yii\db\Migration;

/**
 * Class m180706_222931_create_CountCorrectAnswer_procedure
 */
class m180706_222931_create_CountCorrectAnswer_procedure extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createProcedure = <<< SQL
        DROP PROCEDURE IF EXISTS CountCorrectAnswer;
        
        CREATE PROCEDURE CountCorrectAnswer(
          IN  _userId INT(11),
          OUT _count  INT(11))
          BEGIN
        
            SELECT count(*) AS correct
            INTO _count
            FROM game
              JOIN math ON math.result = game.answer
            WHERE gamblerId = _userId;
        
          END
SQL;

        $this->execute($createProcedure);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('DROP PROCEDURE IF EXISTS CountCorrectAnswer');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180706_222931_create_CountCorrectAnswer_procedure cannot be reverted.\n";

        return false;
    }
    */
}
