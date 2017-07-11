<?php
/**
 * Created by PhpStorm.
 * User: HoaNguyen
 * Date: 7/10/17
 * Time: 20:10
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Create_users_table extends CI_Migration
{
    public function up()
    {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => 255
            ),
            'created_at' => array(
                'type' => 'DATETIME',
                'NULL' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'DATETIME',
                'NULL' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'DATETIME',
                'NULL' => TRUE,
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('users', TRUE);
    }
}
