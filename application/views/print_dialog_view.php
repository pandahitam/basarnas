<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var popup_title = '<?php echo $this->input->post('popup_title'); ?>';

var new_popup = new Ext.create('Ext.window.Window', {
	id: 'win_print_dialog', title: popup_title, iconCls: 'icon-printer', constrainHeader : true, closable: true,
	width: 300, height: 250, bodyStyle: 'padding: 5px;', modal : true, items: [],
	bbar: new Ext.ux.StatusBar({
  	text: 'Ready', id: 'sbwin_print_dialog', iconCls: 'x-status-valid'
  })
});		

<?php }else{ echo "var new_popup = 'GAGAL';"; } ?>


