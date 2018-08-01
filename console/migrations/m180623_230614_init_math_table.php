<?php

use yii\db\Migration;

/**
 * Class m180623_230614_init_math_table
 */
class m180623_230614_init_math_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if (!$this->db->getTableSchema('math')) {
            $this->createTable(
                'math',
                [
                    'id' => $this->primaryKey(),
                    'task' => $this->string(),
                    'result' => $this->decimal(11, 1),
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
            $this->dropTable('math');
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180623_230614_init_math_table cannot be reverted.\n";

        return false;
    }
    */
}
