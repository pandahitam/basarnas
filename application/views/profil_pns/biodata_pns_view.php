<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// FORM BIODATA PNS  --------------------------------------------------------- START
var new_panel_PPNS = new Ext.create('Ext.panel.Panel',{
	id: 'biodata_page', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '84%', border: false,
  items:[MainTab_Biodata]
});	

<?php }else{ echo "var new_panel_PPNS = 'GAGAL';"; } ?>