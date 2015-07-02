<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
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
		$data = json_decode(file_get_contents("php://input"));
		die(var_dump($_POST));
		if(!$this->options('user')){

			$this->response(array('token' => 'qwe'), 200);
		}
		
		$userId = $this->user_model->save($this->options('user'));

		if (!is_null($userId)) {
			$this->response(array('response' => $userId ), 200);
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
