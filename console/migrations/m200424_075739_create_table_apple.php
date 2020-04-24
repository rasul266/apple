<?php

use yii\db\Migration;
use common\models\Apple;
/**
 * Class m200424_075739_create_table_apple
 */
class m200424_075739_create_table_apple extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp(){

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%apple}}', [
            'id' => $this->primaryKey(),
            'color' => $this->string(50),
            'created_at' => $this->integer(),
            'fall_date' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(Apple::STATUS_HANGING_ON_A_TREE),
            'size' =>  $this->smallInteger()->defaultValue(100)
        ], $tableOptions);

    }

        /**
         * {@inheritdoc}
         */

    public function safeDown()
    {
        $this->dropTable('apple');
    }

}
