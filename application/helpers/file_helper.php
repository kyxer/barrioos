<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('base64_to_png'))
{

	function base64_to_png($base64_string, $output_file) {
	    $ifp = fopen($output_file, "wb"); 

	    $data = explode(',', $base64_string);

	    fwrite($ifp, base64_decode($data[1])); 
	    fclose($ifp); 

	    return $output_file; 
	}
}

if ( ! function_exists('tempnam_sfx'))
{

	function tempnam_sfx($path, $suffix){ 

		$i = 50;
      do 
      { 

        $file = $path.'/AVA_'.mt_rand().'.'.$suffix; 
        //die(var_dump($file));
        $fp = @fopen($file, 'x+'); 
        $i--;
      } 
      while(!$fp && $i>0); 

      fclose($fp); 
      return $file; 
   } 
}

if ( ! function_exists('create_thumb'))
{
	function create_thumb($source_image, $width = 80, $height = 80 ){

		$CI =& get_instance();
		 
		$config['image_library'] = 'gd2';
		$config['source_image']	= $source_image;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width']	= $width;
		$config['height']	= $height;

		$CI->load->library('image_lib', $config);

		return $CI->image_lib->resize();
	}
}


if ( ! function_exists('name_thumb'))
{
	function name_thumb($source_image){

		$arr = explode('.',$source_image);
	
		return implode("_thumb.", $arr);
	}
}




