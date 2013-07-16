<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Penilai = '', Cur_Form_Caller_Penilai = '', fmode = '';

// POPUP REFERENSI PENILAI ---------------------------------------------------- START
Ext.define('MSearch_RefPenilai', {extend: 'Ext.data.Model',
   fields: ['ID_Pegawai', 'NIP', 'nama_lengkap', 'f_namalengkap', 'gelar_d', 'gelar_b', 'nama_jab']
});
var Reader_Search_RefPenilai = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefPenilai', root: 'results', totalProperty: 'total', idProperty: 'ID_Pegawai'  	
});
var Proxy_Search_RefPenilai = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'browse_ref/ext_get_all_penilai', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefPenilai
});
var Data_Search_RefPenilai = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefPenilai', model: 'MSearch_RefPenilai', pageSize: 10,	noCache: false, autoLoad: true,
   proxy: Proxy_Search_RefPenilai
});

var Search_RefPenilai = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPenilai', store: Data_Search_RefPenilai, emptyText: 'Ketik di sini untuk pencarian', width: 550});
var tbSearch_RefPenilai = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPenilai',
	items:[
		Search_RefPenilai, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Penilai',
		 handler: function(){SetTo_Form_Caller_Penilai();}
		}
  ]
});
		
var cbGrid_Search_RefPenilai = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefPenilai = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefPenilai', store: Data_Search_RefPenilai, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPenilai, columnLines: true, invalidateScrollerOnRefresh: false,
	columns: [
 		{header: "NIP", dataIndex: 'NIP', width: 140}, 
 		{header: "Nama Lengkap", dataIndex: 'f_namalengkap', width: 280},
 		{header: "Jabatan", dataIndex: 'nama_jab', width: 150}
 	], bbar: tbSearch_RefPenilai,
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPenilai, dock: 'bottom', displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('PILIH_Penilai').handler.call(Ext.getCmp("PILIH_Penilai").scope);
  	}
  } 	
});

var win_popup_RefPenilai = new Ext.create('widget.window', {
 	id: 'win_popup_RefPenilai', title: 'Referensi Penilai', iconCls: 'icon-human',
 	modal:true, plain:true, closable: true, width: 650, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefPenilai]
});

var new_popup_ref = win_popup_RefPenilai;

// POPUP REFERENSI PENILAI ---------------------------------------------------- END

// FUNCTION REF PENILAI ------------------------------------------------------- START 
function Funct_win_popup_RefPenilai(form_name, vfmode){
	Str_Cur_Form_Caller_Penilai = form_name;
	Cur_Form_Caller_Penilai = window[form_name];
	fmode = vfmode;
	win_popup_RefPenilai.show();
}

function SetTo_Form_Caller_Penilai(){
	var sm = grid_Search_RefPenilai.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {penilai_dp3:sel[0].get('f_namalengkap')};
				break;
			default:
				var value_form = {f_namalengkap:sel[0].get('f_namalengkap')};
		}		
	  Cur_Form_Caller_Penilai.getForm().setValues(value_form);	  
	  win_popup_RefPenilai.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PENILAI ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>