<?php

use Phinx\Migration\AbstractMigration;

class TestMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $tag = $this->table('tag');
        $tag
            ->addColumn('name', 'string', ['limit' => 45, 'null' => false])
            ->addColumn('description', 'text')
            ->addColumn('context', 'string', ['limit' => 25])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('visibility', 'boolean', ['null' => false, 'signed' => false, 'default' => 1])
            ;

        $tag->addIndex(['name', 'created_by', 'visibility'], ['unique' => true, 'name' => 'name_creator_visible']);
        $tag->addIndex(['context']);

        $tag->create();

    }
}
