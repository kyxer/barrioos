<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('send_post'))
{
	function send_post($url, $post_fields, $headers = NULL  ) {
		
		$timeout = 30;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);

		if(!is_null($headers))
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_fields);

		$out = curl_exec($curl);

		if(curl_errno($curl)){
		    die(var_dump('error:' . curl_error($curl)));
		}

  		curl_close ($curl);

  		return json_decode($out,true);
	}
}

  

  
  
  
  

  
  
  
 