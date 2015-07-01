<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CLI extends CI_Controller {



	public function install($pass)
	{
		if ($pass != "123456789") return;


		$this->load->dbforge();
		

		// create users table
		$fields = array(
			'id' => array(
				 'type' => 'INT',
				 'constraint' => 11, 
				 'null' => false,
				 'auto_increment' => true
			),
			'email' => array(
				 'type' => 'VARCHAR',
				 'constraint' => '255',
				 'null' => false
			),
			'password' => array(
				 'type' => 'VARCHAR',
				 'constraint' => '255',
				 'null' => false
			),
			'postal_code' =>array(
				'type' => 'INT' ,
				'constraint' => 11,
				'null' => false
			),
			'address' => array(
				'type' => 'TEXT',
				'null' => true
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			),
			'avatar_thumbnail' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			),
			'avatar_standar'=> array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			),
			'is_active' => array(
				'type' => 'INT' ,
				'constraint' => 1,
				'null' => false
			)
		);	
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('users');
		

		echo "succes install database";
		
       
	}	
}