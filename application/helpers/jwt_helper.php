<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/JWT.php';

if ( ! function_exists('jwd_create_token'))
{
    function jwd_create_token($user)
    {
        $CI =& get_instance();
     	$CI->load->library('JWT');
     	$CI->load->helper('date');

     	$token = array(
		    "exp" => strtotime('+30 day', now()),
		    "iat" => now(),
		    "sub" => $user['id']
		);

		return JWT::encode($token, JWT_TOKEN_SECRET);
    }   
}

if ( ! function_exists('is_authenticated'))
{

    function is_authenticated($user)
    {
        $CI =& get_instance();
        $CI->load->library('JWT');

        $CI->input->get_request_header('Authorization');

        

        return JWT::encode($token, JWT_TOKEN_SECRET);
    }   

}