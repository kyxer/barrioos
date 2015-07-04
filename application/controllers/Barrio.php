<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Barrio extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('barrio_model');
	}

	public function find_get($postalCode)
	{
		
		if (!$postalCode) {
			$this->response(NULL, 400);
		}

		$barrio = $this->barrio_model->getByPostalCode($postalCode);

		if (!is_null($barrio)) {
			
			$this->response(array('barrio' => $barrio), 200);
		}
		else 
		{
			$this->response(array('error' => 'Not Found'), 404);
		}
	}

}