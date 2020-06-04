<?php

use Phinx\Migration\AbstractMigration;

class SuperAdminMigration extends AbstractMigration
{
   
    public function change()
    {
        $superAdminTable = $this->table('super_admin');
        $superAdminTable->addColumn('username', 'string')
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
