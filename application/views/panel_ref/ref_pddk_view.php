<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Pddk = '', Cur_Form_Caller_Pddk = '', fmode = '';

// POPUP REFERENSI PENDIDIKAN ---------------------------------------------------- START
Ext.define('MSearch_RefPddk', {extend: 'Ext.data.Model',
	fields: ['ID_Pddk', 'kode_pddk', 'nama_pddk', 'nama_jenjang_pddk']
});
var Reader_Search_RefPddk = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefPddk', root: 'results', totalProperty: 'total', idProperty: 'ID_Pddk'  	
});	
var Proxy_Search_RefPddk = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_Search_RefPddk', url: BASE_URL + 'browse_ref/ext_get_all_pendidikan', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefPddk
});
var Data_Search_RefPddk = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefPddk', model: 'MSearch_RefPddk', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefPddk
});

var search_RefPddk = new Ext.create('Ext.ux.form.SearchField', {id: 'search_RefPddk', store: Data_Search_RefPddk, emptyText: 'Ketik di sini untuk pencarian', width: 380});
var tbSearch_RefPddk = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPddk',
	items:[
		search_RefPddk, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Pddk',
		 handler: function(){SetTo_Form_Caller_Pddk();}
		}
  ]
});
		
var cbGrid_Search_RefPddk = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefPddk = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefPddk', store: Data_Search_RefPddk, frame: true, border: true, loadMask: true,
 	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPddk, columnLines: true,
 	invalidateScrollerOnRefresh: false, 
	columns: [
 		{header: "Nama Pendidikan", dataIndex: 'nama_pddk', width: 340},
 		{header: "Jenjang", dataIndex: 'nama_jenjang_pddk', width: 100}
 	], bbar: tbSearch_RefPddk,
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPddk, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Pddk').handler.call(Ext.getCmp("PILIH_Pddk").scope);
 		}
 	}  	
});
	
var win_popup_RefPddk = new Ext.create('widget.window', {
 	id: 'win_popup_RefPddk', title: 'Referensi Pendidikan', iconCls: 'icon-toga',
 	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefPddk]
});

var new_popup_ref = win_popup_RefPddk;

// POPUP REFERENSI PENDIDIKAN ---------------------------------------------------- END

// FUNCTION REF PENDIDIKAN ------------------------------------------------------- START 
function Funct_win_popup_RefPddk(form_name, vfmode){
	Str_Cur_Form_Caller_Pddk = form_name;
	Cur_Form_Caller_Pddk = window[form_name];
	fmode = vfmode;
	win_popup_RefPddk.show();
}

function SetTo_Form_Caller_Pddk(){
	var sm = grid_Search_RefPddk.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_pddk:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk')};
				break;
			case 2:
				var value_form = {kode_pddk_pmkg:sel[0].get('kode_pddk'), nama_pddk_pmkg:sel[0].get('nama_pddk')};
				break;
			case 3:
				var value_form = {kode_pddk_si:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk')};
				break;
			case 4:
				var value_form = {kode_pddk_anak:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk')};
				break;
			default:
				var value_form = {kode_pddk:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk')};
		}
	  Cur_Form_Caller_Pddk.getForm().setValues(value_form);
	  
	  win_popup_RefPddk.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PENDIDIKAN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>