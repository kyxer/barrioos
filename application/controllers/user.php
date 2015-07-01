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

	public function index_post()
	{		
		if(!$this->post('user')){
			$this->response(NULL, 400);
		}
		
		$userId = $this->user_model->save($this->post('user'));

		if (!is_null($userId)) {
			$this->response(array('response' => $userId ), 200);
		}
		else 
		{
			$this->response(array('error' => 'Internal Server Error' , $userId ), 500);
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
