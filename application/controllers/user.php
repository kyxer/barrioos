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
		$this->load->helper('file');
		$this->load->helper('curl');
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
				$this->response(array('user' => $user, 'token' => $val['token'] ), 200);
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
			$this->response(array('error' => 'Internal Server Error'), 500);
		}
	}

	public function avatar_options($id){

		$this->response(array('response' => 'OK' ), 200);

	}

	public function avatar_post($id) {

		$tempImage = tempnam_sfx(sys_get_temp_dir(), "jpg");
		$imageName = base64_to_png($this->post('image'), $tempImage);
		$thumbImage = create_thumb($imageName);
		$nameThumb = name_thumb($imageName);
		
		$handle = fopen($imageName, "r");
 		$data = fread($handle, filesize($imageName));
		$headers = array('Authorization: Client-ID ' . IMGUR_CLIENT_ID);
		$postFields = array('image' => base64_encode($data));	

		$dataImage = send_post(IMGUR_URL_UPLOAD_IMAGE, $postFields, $headers);


		$handle = fopen($nameThumb, "r");
 		$data = fread($handle, filesize($nameThumb));
		$headers = array('Authorization: Client-ID ' . IMGUR_CLIENT_ID);
		$postFields = array('image' => base64_encode($data));

		$dataThumb = send_post(IMGUR_URL_UPLOAD_IMAGE, $postFields, $headers);

		$val['avatar_thumbnail'] = $dataThumb['data']['link'];
		$val['avatar_standar'] = $dataImage['data']['link'];


		$userId = $this->user_model->update($id, $val);

		if (!is_null($userId)) {
			//unlink($imageName);
			//unlink($nameThumb);
			$this->response(array('avatars' => $val ), 200);
		}
		else 
		{
			$this->response(array('error' => 'Internal Server Error'), 500);
		}
		
	}

}
