<?php

use Phinx\Migration\AbstractMigration;

class InitialMigration extends AbstractMigration
{
   
    public function change()
    {
        $adminTable = $this->table('admin');
        $adminTable->addColumn('username', 'string')
            ->addColumn('password', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();

        $filesTable = $this->table('files');
        $filesTable->addColumn('filepath', 'string')
            ->addColumn('qr_code_text', 'string')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime')
            ->create();
    }
}
