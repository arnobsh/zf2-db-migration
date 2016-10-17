<?php

use Phinx\Migration\AbstractMigration;

class TestMigration1136 extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // inserting only one row
        $singleRow = [
            'id'    => 5,
            'name'  => 'In Progress',
            'description'  => 'Test Data5',
            'created_by'  => 3,
            'visibility'  => 1
        ];

        $table = $this->table('tag');
        $table->insert($singleRow);
        $table->saveData();

        // inserting multiple rows
        $rows = [
            [
                'id' => 8,
                'name' => 'Stopped',
                'description' => 'Test Data',
                'created_by' => 4,
                'visibility' => 1
            ],
            [
                'id' => 9,
                'name' => 'Queued',
                'description' => 'Test Data',
                'created_by' => 6,
                'visibility' => 1
            ]
        ];

        // this is a handy shortcut
        $this->insert('tag', $rows);
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM tag');
    }
}
