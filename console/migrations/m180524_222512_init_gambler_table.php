<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180524_222512_init_gambler_table
 */
class m180524_222512_init_gambler_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        if (!$this->db->getTableSchema('gambler')) {
            $this->createTable(
                'gambler',
                [
                    'id' => $this->primaryKey(),
                    'authKey' => $this->string()->notNull(),
                    'manner' => "ENUM('sync', 'async') NOT NULL DEFAULT 'async'",
                    'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        if (!$this->db->getTableSchema('math')) {
            $this->dropTable('gambler');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180524_222512_init_gambler_table cannot be reverted.\n";

        return false;
    }
    */
}
