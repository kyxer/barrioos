<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/JWT.php';

if ( ! function_exists('jwd_create_token'))
{
    function jwd_create_token($user)
    {
        $CI =& get_instance();
     	$CI->load->library('JWT');
     	$CI->load->library('date');

     	$token = array(
		    "exp" => strtotime('+30 day', $CI->date->now());,
		    "iat" => $CI->date->now(),
		    "sub" => $user['id']
		);

		return $CI->JWT::encode($token, JWT_TOKEN_SECRET);

    }   
}