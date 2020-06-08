<?php

use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
{
   
    public function change()
    {
        $adminTable = $this->table('admins');
        $adminTable->addColumn('username', 'string')
            ->addColumn('password', 'text')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $imageTable = $this->table('images');
        $imageTable->addColumn('filepath', 'string')
            ->addColumn('qr_code_text', 'text')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $superAdminTable = $this->table('super_admins');
        $superAdminTable->addColumn('username', 'string')
            ->addColumn('password', 'text')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
