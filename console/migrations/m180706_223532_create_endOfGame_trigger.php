<?php

use yii\db\Migration;

/**
 * Class m180706_223532_create_endOfGame_trigger
 */
class m180706_223532_create_endOfGame_trigger extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $createTrigger = <<< SQL
        DROP TRIGGER IF EXISTS endOfGame;
          
        CREATE TRIGGER endOfGame
          BEFORE DELETE
          ON gambler
          FOR EACH ROW
          BEGIN
        
            DELETE
            FROM math
            WHERE id IN (SELECT mathId
                         FROM game
                         WHERE gamblerId = OLD.id);
        
          END;
SQL;

        $this->execute($createTrigger);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("
        DROP TRIGGER IF EXISTS `endOfGame`;
        ");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180706_223532_create_endOfGame_trigger cannot be reverted.\n";

        return false;
    }
    */
}
