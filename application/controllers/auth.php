<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('jwt');

	}

	public function index_post()
	{		
		if(!$this->post('auth')){
			$this->response(NULL, 400);
		}
		
		$user = $this->user_model->auth($this->post('auth'));

		$token = jwd_create_token($user);

		if (!is_null($user)) {
			$this->response(array('response' => $userId ), 200);
		}
		else 
		{
			$this->response(array('error' => 'Internal Server Error' , $userId ), 500);
		}
	}

}