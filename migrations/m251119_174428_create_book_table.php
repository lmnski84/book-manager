<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m251119_174428_create_book_table extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-book-user_id}}',
            '{{%book}}',
            'user_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-book-user_id}}',
            '{{%book}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-book-user_id}}',
            '{{%book}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-book-user_id}}',
            '{{%book}}'
        );

        $this->dropTable('{{%book}}');
    }
}
