<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var new_popup = new Ext.create('Ext.Window', {
	id: 'winmappopup', title: 'Kode Kansar: ' + <?php echo($location) ?>, iconCls: 'icon-information',
	width: 640, height: 480, bodyStyle: 'padding: 5px;', 	
	constrainHeader : true, closable: true, modal : true,
	//items: [],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready',
    id: 'sbWinmappopup',
    iconCls: 'x-status-valid'
  })
});

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>