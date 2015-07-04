<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barrio_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function getByPostalCode($postalCode = NULL)
	{
		if (!is_null($postalCode)) 
		{
			$query = $this->db->select('*')->from('barrios')->where('postal_code', $postalCode)->get();
			if ($query->num_rows() == 1) {

				return $query->row_array();
			}

			return NULL;
		}
	}

}