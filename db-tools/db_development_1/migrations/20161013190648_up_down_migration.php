<?php

use Phinx\Migration\AbstractMigration;

class UpDownMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        // inserting only one row
        $singleRow = [
            'id'    => 1,
            'name'  => 'In Progress',
            'description'  => 'Test Data',
            'created_by'  => 2,
            'visibility'  => 1
        ];

        $table = $this->table('tag');
        $table->insert($singleRow);
        $table->saveData();

        // inserting multiple rows
        $rows = [
            [
                'id' => 2,
                'name' => 'Stopped',
                'description' => 'Test Data',
                'created_by' => 3,
                'visibility' => 1
            ],
            [
                'id' => 3,
                'name' => 'Queued',
                'description' => 'Test Data',
                'created_by' => 4,
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
