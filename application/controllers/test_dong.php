<?php
class Test_Dong extends CI_Controller{
  function __construct(){
  	parent::__construct();
  }
	
  function index(){
		$script_extjs = "
		var newpanel = new Ext.create('Ext.panel.Panel',{
			id: 'test_dong',
			region: 'center',
  		layout: 'card',
  		border: true,
  		title: 'TEST DONG',
  		items:[]
		});
		";
		header("Content-Type: application/x-javascript");
		echo $script_extjs;
  }
  
}
?>