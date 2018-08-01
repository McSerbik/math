<?php

use yii\db\Migration;

/**
 * Class m180624_000034_init_game_table
 */
class m180624_000034_init_game_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        if (!$this->db->getTableSchema('game')) {
            $this->createTable(
                'game',
                [
                    'id' => $this->primaryKey(),
                    'gamblerId' => $this->integer(11)->notNull(),
                    'mathId' => $this->integer(11)->notNull(),
                    'round' => $this->integer(11)->defaultValue(1),
                    'answer' => $this->decimal(11, 1),
                ]
            );

            $this->addForeignKey('fkGamblerId', 'game', 'gamblerId', 'gambler', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('fkMathId', 'game', 'mathId', 'math', 'id', 'CASCADE', 'CASCADE');

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!$this->db->getTableSchema('game')) {
            $this->dropForeignKey('fkGamblerId', 'game');
            $this->dropForeignKey('fkMathId', 'game');
            $this->dropTable('game');
        }


        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180624_000034_init_game_table cannot be reverted.\n";

        return false;
    }
    */
}
