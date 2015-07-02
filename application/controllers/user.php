<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('jwt');
		$this->load->helper('password');
	}

	public function find_get ($id) 
	{

		if (!$id) {
			$this->response(NULL, 400);
		}

		$user = $this->user_model->get($id);

		if (!is_null($user)) {
			
			$this->response(array('response' => $user), 200);
		}
		else 
		{
			$this->response(array('error' => 'Not Found'), 404);
		}
	}

	public function index_options()
	{		

		$this->response(array('response' => 'OK' ), 200);
		
	}

	public function index_post()
	{		

		if(!$this->post('user')){

			$this->response(array('error' => 'BAD REQUEST'), 400);
		}
		
		$user = $this->post('user');

		$user['password'] = phpass_hash($user);

		$userId = $this->user_model->save($user);

		if (!is_null($userId)) {

			$user['id'] = $userId;
			unset($user['password']);
			$val['token']= jwd_create_token($user);

			$result = $this->user_model->update($userId, $val);

			if(!is_null($result))
			{
				$this->response(array('user' => $user, 'token' =>$val['token'] ), 200);
			}
			else 
			{	
				$this->response(array('error' => 'Internal Server Error'), 500);
			}
		}
		else 
		{	
			$this->response(array('error' => 'Internal Server Error'), 500);
		}
	}

	public function index_put($id){

		if(!$this->put('user') || !$id){
			$this->response(NULL, 400);
		}
		
		$userId = $this->user_model->update($id, $this->put('user'));

		if (!is_null($userId)) {
			$this->response(array('response' => TRUE , $userId ), 200);
		}
		else 
		{
			$this->response(array('error' => 'Internal Server Error' , $userId ), 500);
		}
	}

}
