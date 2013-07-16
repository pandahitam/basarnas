<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function compress()
{
	$CI =& get_instance();
	$buffer = $CI->output->get_output();
 
	$search = array('/> </', '(/\// .+)', '#/\*[^*]*\*+([^/][^*]*\*+)*/#');
	$replace = array('><','','');
 
	$buffer = preg_replace($search, $replace, $buffer);
 
	$CI->output->set_output($buffer);
	$CI->output->_display();
}
 
/* End of file compress.php */
/* Location: application/hooks/compress.php */