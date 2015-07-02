<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/PasswordHash.php';

if ( ! function_exists('phpass_hash'))
{
    function phpass_hash($user)
    {
        $CI =& get_instance();
     	$CI->load->library('PasswordHash');

     	$hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);
		return $hasher->HashPassword($user['password']);
    }   
}

if ( ! function_exists('phpass_check'))
{
    function phpass_check($user, $auth)
    {
        $CI =& get_instance();
        $CI->load->library('PasswordHash');

        $hasher = new PasswordHash(HASH_COST_LOG2, HASH_PORTABLE);

        return $hasher->CheckPassword($auth['password'], $user['password']);
    }   
}

