<?php

use Phinx\Migration\AbstractMigration;

class InitialData extends AbstractMigration
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
	 * @throws \InvalidArgumentException
	 * @throws \RuntimeException
	 */
    public function change()
    {
		$this->table('lunches', ['id' => false, 'primary_key' => 'id'])
			->addColumn('id', 'uuid')
			->addColumn('name', 'string', ['limit' => 255])
			->addColumn('participants', 'jsonb')
			->addColumn('potentialPlaces', 'jsonb')
			->addColumn('votes', 'jsonb')
			->create();
    }
}
