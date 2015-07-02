<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Auth extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('jwt');
		$this->load->helper('password');

	}

	public function index_options()
	{		
		$this->response(array('response' => 'OK' ), 200);
	}

	public function index_post()
	{		
		if(!$this->post('auth')){
			$this->response(NULL, 400);
		}
		
		$auth = $this->post('auth');
		$user = $this->user_model->auth($auth);

		if(!is_null($user)) 
		{
			if(phpass_check($user, $auth))
			{	
				$val['token']= jwd_create_token($user);
				$result = $this->user_model->update($user['id'], $val);

				unset($user['password']);

				$this->response(array('token' => $val['token'], 'user' => $user , 200));
			}
			else
			{
				$this->response(array('message' => array( 'password' => 'Contraseña Incorrecta')), 401);
			}
		}
		else 
		{
			$this->response(array('message' => array( 'email' => 'Correo Incorrecto')), 401);
		}
	}

}