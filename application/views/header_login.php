<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php if(isset($title)){echo $title;}else{echo "SIMPEG";} ?></title>
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon" /> 
  <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
  <meta name="Keywords" content="" />
  <meta name="Description" content="" />
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/icon_css.css"/>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/resources/css/ext-all.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/css/statusbar.css"/>

  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/StatusBar.js"></script>
	
	<script type="text/javascript">
    var BASE_URL = '<?php echo base_url(); ?>';
    var BASE_ICONS = BASE_URL + 'assets/images/icons/';
    var Time_Out = 60000;
    Ext.BLANK_IMAGE_URL = BASE_URL + 'assets/js/ext/resources/themes/images/access/tree/s.gif';
		Ext.Loader.setConfig({enabled: true});
		Ext.Loader.setPath('Ext.ux', BASE_URL + 'assets/js/ext/ux');	
		Ext.require(['*']);
		
  	Ext.onReady(function() {
    	Ext.QuickTips.init();
      Ext.form.Field.prototype.msgTarget = 'side';
    });
  </script>

  <style>body {background: #7F99BE url(<?php echo base_url(); ?>assets/images/extjs/desk.jpg) no-repeat;}</style>
	    


	
