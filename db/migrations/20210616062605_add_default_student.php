<?php

use Phinx\Migration\AbstractMigration;

class AddDefaultStudent extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $table = $this->table('students');
        $singleRow = [
            'sid'  => 1,
            'fname' => 'sharan',
            'lname' => 'reddy',
            'rollno' => '17881a05g6',
            'email' => 'sharanreddy@gmail.com',
            'password' => 'Sharan@123',
            'mobile' => '1234567890',
            'gender' => 'Male',
            'year' => '4th Year',
            'branch' => 'CSE-C',
            'profilepic' => NULL
        ];
        $table->insert($singleRow);
        $table->saveData();
    }

    public function down()
    {
        $this->execute('DELETE FROM students where rollno ="17881a05g6"');
    }
}
