<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Pekerjaan = '', Cur_Form_Caller_Pekerjaan = '', fmode = '';

// POPUP REFERENSI PEKERJAAN ---------------------------------------------------- START
Ext.define('MSearch_RefPekerjaan', {extend: 'Ext.data.Model',
  fields: ['ID_Kerja', 'kode_pekerjaan', 'nama_pekerjaan']
});
var Reader_Search_RefPekerjaan = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefPekerjaan', root: 'results', totalProperty: 'total', idProperty: 'ID_Kerja'  	
});	
var Proxy_Search_RefPekerjaan = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_Search_RefPekerjaan', url: BASE_URL + 'browse_ref/ext_get_all_pekerjaan', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefPekerjaan
});
var Data_Search_RefPekerjaan = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefPekerjaan', model: 'MSearch_RefPekerjaan', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefPekerjaan
});

var Search_RefPekerjaan = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPekerjaan', store: Data_Search_RefPekerjaan, emptyText: 'Ketik di sini untuk pencarian', width: 380});
var tbSearch_RefPekerjaan = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPekerjaan',
	items:[
		Search_RefPekerjaan, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Pekerjaan',
		 handler: function(){SetTo_Form_Caller_Pekerjaan();}
		}
  ]
});

var cbGrid_Search_RefPekerjaan = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefPekerjaan = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefPekerjaan', store: Data_Search_RefPekerjaan, frame: true, border: true, loadMask: true,
 	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPekerjaan, columnLines: true,
 	invalidateScrollerOnRefresh: false, 
	columns: [
 		{header: "Nama Pekerjaan", dataIndex: 'nama_pekerjaan', width: 400}
 	], bbar: tbSearch_RefPekerjaan,
 	dockedItems: [{
 		xtype: 'pagingtoolbar', store: Data_Search_RefPekerjaan, dock: 'bottom', displayInfo: true
 	}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Pekerjaan').handler.call(Ext.getCmp("PILIH_Pekerjaan").scope);
 		}
 	}  	
});

var win_popup_RefPekerjaan = new Ext.create('widget.window', {
 	id: 'win_popup_RefPekerjaan', title: 'Referensi Pekerjaan', iconCls: 'icon-toga',
 	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefPekerjaan]
});
	
var new_popup_ref = win_popup_RefPekerjaan;

// POPUP REFERENSI PEKERJAAN ---------------------------------------------------- END

// FUNCTION REF PEKERJAAN ------------------------------------------------------- START 
function Funct_win_popup_RefPekerjaan(form_name, vfmode){
	Str_Cur_Form_Caller_Pekerjaan = form_name;
	Cur_Form_Caller_Pekerjaan = window[form_name];
	fmode = vfmode;
	win_popup_RefPekerjaan.show();
}

function SetTo_Form_Caller_Pekerjaan(){
	var sm = grid_Search_RefPekerjaan.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_pekerjaan:sel[0].get('kode_pekerjaan'), nama_pekerjaan:sel[0].get('nama_pekerjaan')};
				break;
			case 2:
				var value_form = {pekerjaan_ayah:sel[0].get('nama_pekerjaan')};
				break;
			case 3:
				var value_form = {pekerjaan_ibu:sel[0].get('nama_pekerjaan')};
				break;
			case 4:
				var value_form = {pekerjaan_si:sel[0].get('nama_pekerjaan')};
				break;
			case 5:
				var value_form = {pekerjaan_anak:sel[0].get('nama_pekerjaan')};
				break;
			case 6:
				var value_form = {pekerjaan_ayah_mertua:sel[0].get('nama_pekerjaan')};
				break;
			case 7:
				var value_form = {pekerjaan_ibu_mertua:sel[0].get('nama_pekerjaan')};
				break;
			case 8:
				var value_form = {pekerjaan_sdr:sel[0].get('nama_pekerjaan')};
				break;
			default:
				var value_form = {kode_pekerjaan:sel[0].get('kode_pekerjaan'), nama_pekerjaan:sel[0].get('nama_pekerjaan')};
		}
	  Cur_Form_Caller_Pekerjaan.getForm().setValues(value_form);
	  
	  win_popup_RefPekerjaan.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PEKERJAAN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>