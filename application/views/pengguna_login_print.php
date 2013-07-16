<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var mode_cetak = "<?php echo $this->input->post("mode_cetak"); ?>";  

<?php if($this->input->post("dari")){?>
var dari = "<?php echo $this->input->post("dari"); ?>";  
<?php }else{ ?>
var dari = "-";  
<?php } ?>

<?php if($this->input->post("sampai")){?>
var sampai = "<?php echo $this->input->post("sampai"); ?>";  
<?php }else{ ?>
var sampai = "-";  
<?php } ?>

var terpilih = "<?php echo $this->input->post("terpilih"); ?>";  

var docprint = new Ext.create('Ext.window.Window', {
		title: 'Cetak Pengguna Login', iconCls: 'icon-printer',
		constrainHeader : true, closable: true, maximizable: true,
		width: 600, height: 500, bodyStyle: 'padding: 5px;',
		modal : true,
		items: [{
			xtype:'tabpanel', activeTab : 0,
      width: '100%', height: '100%',
      items: [{
      	title: 'Preview', frame: false, collapsible: true, autoScroll: true,
      	iconCls: 'icon-pdf',
      	items: [{
      		xtype : 'miframe', frame: false, height: '100%',
        	src : BASE_URL + 'pengguna_login/ext_print_pdf/1/' + mode_cetak + '/' + dari + '/' + sampai + '/' + terpilih
        }]
      }]                     
		}]		
});

<?php }else{ echo "var docprint = 'GAGAL';"; } ?>
