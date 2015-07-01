<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class User_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function get($id = NULL)
	{
		if (!is_null($id)) 
		{
			$query = $this->db->select('*')->from('users')->where('id', $id)->get();
			if ($query->num_rows() == 1) {

				return $query->row_array();
			}

			return NULL;
		}
	}

	public function save($user){

		$this->db->set(
			$this->_setUser($user)
		)->insert('users');

		if($this->db->affected_row() === 1){

			return $this->db->insert_id();
		}
		else
		{
			return NULL;
		}
	}

	public function update($id, $user){
		$this->db->set(
			$this->_setUser($user)
		)
		->where('id',$id)
		->update('users');

		if($this->db->affected_row() === 1){

			return TRUE;
		}
		else
		{
			return NULL;
		}
	}

	private function _setUser($user){
		return array (
			'name'			=> $user['name'],
			'email' 		=> $user['email'],
			'password' 		=> $user['password'],
			'postal_code' 	=> $user['postal_code']
		);
	}
}

?>