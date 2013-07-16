<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Pangkat = '', Cur_Form_Caller_Pangkat = '', fmode = '';
var vkode_golru = "<?php echo $this->input->post('VKEY'); ?>";

// POPUP REFERENSI PANGKAT, GOLRU ---------------------------------------------------- START
	Ext.define('MSearch_RefGolru_UL', {extend: 'Ext.data.Model',
    fields: ['ID_Golru', 'kode_golru', 'nama_pangkat', 'nama_golru']
	});
	var Reader_Search_RefGolru_UL = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefGolru_UL', root: 'results', totalProperty: 'total', idProperty: 'ID_Golru'  	
	});	
	var Proxy_Search_RefGolru_UL = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Search_RefGolru_UL', url: BASE_URL + 'browse_ref/ext_get_all_golru_up_level', actionMethods: {read:'POST'},  extraParams :{id_open: '1', kode_golru: vkode_golru}, reader: Reader_Search_RefGolru_UL
	});
	var Data_Search_RefGolru_UL = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefGolru_UL', model: 'MSearch_RefGolru_UL', pageSize: 10, noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefGolru_UL
	});

	var search_RefGolru_UL = new Ext.create('Ext.ux.form.SearchField', {id: 'search_RefGolru_UL', store: Data_Search_RefGolru_UL, emptyText: 'Ketik di sini untuk pencarian', width: 240});
	var tbSearch_RefGolru_UL = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefGolru_UL',
	items:[
		search_RefGolru_UL, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_PgwPangkat',
		 handler: function(){SetTo_Form_Caller_Pangkat();}
		}
  ]
	});
		
	var cbGrid_Search_RefGolru_UL = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefGolru_UL = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefGolru_UL', store: Data_Search_RefGolru_UL, frame: true, border: true, loadMask: true,
  	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefGolru_UL, columnLines: true,
  	invalidateScrollerOnRefresh: false, 
		columns: [
  		{header: "Pangkat", dataIndex: 'nama_pangkat', width: 180},
  		{header: "Golongan/Ruang", dataIndex: 'nama_golru', width: 110}
  	], bbar: tbSearch_RefGolru_UL,
  	dockedItems: [{
  		xtype: 'pagingtoolbar', store: Data_Search_RefGolru_UL, dock: 'bottom', displayInfo: true
  	}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_PgwPangkat').handler.call(Ext.getCmp("PILIH_PgwPangkat").scope);
  		}
  	}  	
	});
	
	var win_popup_RefGolru_UL = new Ext.create('widget.window', {
   	id: 'win_popup_RefGolru_UL', title: 'Referensi Pangkat, Golongan/Ruang', iconCls: 'icon-gears',
   	modal:true, plain:true, closable: true, width: 380, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefGolru_UL]
	});

var new_popup_ref = win_popup_RefGolru_UL;

// POPUP REFERENSI PANGKAT, GOLRU ---------------------------------------------------- END

// FUNCTION REF PANGKAT, GOLRU ------------------------------------------------------- START 
function Funct_win_popup_RefGolru_UL(form_name, vfmode){
	Str_Cur_Form_Caller_Pangkat = form_name;
	Cur_Form_Caller_Pangkat = window[form_name];
	fmode = vfmode;
	win_popup_RefGolru_UL.show();
}

function SetTo_Form_Caller_Pangkat(value_form){
	var sm = grid_Search_RefGolru_UL.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_golru_usul:sel[0].get('kode_golru'), nama_pangkat_usul:sel[0].get('nama_pangkat'), nama_golru_usul:sel[0].get('nama_golru')};
				break;
			default:
				var value_form = {kode_golru:sel[0].get('kode_golru'), nama_pangkat:sel[0].get('nama_pangkat'), nama_golru:sel[0].get('nama_golru')};
		}
	  Cur_Form_Caller_Pangkat.getForm().setValues(value_form);
	  
	  win_popup_RefGolru_UL.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PANGKAT, GOLRU ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>