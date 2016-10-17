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
        $tagRelation = $this->table('tag_relation');
        $tagRelation
            ->addColumn('tag_id', 'integer', ['null' => false])
            ->addColumn('entity_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('entity_type', 'string', ['limit' => 45, 'null' => false])
            ->addColumn('created', 'timestamp', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('created_by', 'integer', ['signed' => false, 'null' => false])
        ;

        $tagRelation->addIndex(['tag_id']);
        $tagRelation->addIndex(['entity_id', 'entity_type'], ['name' => 'entity']);

        $tagRelation->create();

    }
}
