<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Pddk = '', Cur_Form_Caller_Pddk = '', fmode = '';

// POPUP REFERENSI PENDIDIKAN ---------------------------------------------------- START
	Ext.define('MSearch_RefPgwPddk', {extend: 'Ext.data.Model',
    fields: ['IDP_Pddk', 'kode_pddk', 'nama_pddk', 'nama_jenjang_pddk', 'tahun_lulus']
	});
	var Reader_Search_RefPgwPddk = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefPgwPddk', root: 'results', totalProperty: 'total', idProperty: 'IDP_Pddk'  	
	});	
	var Proxy_Search_RefPgwPddk = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Search_RefPgwPddk', url: BASE_URL + 'browse_ref/ext_get_all_pddk_pgw', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefPgwPddk
	});
	var Data_Search_RefPgwPddk = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefPgwPddk', model: 'MSearch_RefPgwPddk', pageSize: 10, noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefPgwPddk
	});

	var search_RefPgwPddk = new Ext.create('Ext.ux.form.SearchField', {id: 'search_RefPgwPddk', store: Data_Search_RefPgwPddk, emptyText: 'Ketik di sini untuk pencarian', width: 380});
	var tbSearch_RefPgwPddk = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPgwPddk',
	items:[
		search_RefPgwPddk, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_PgwPddk',
		 handler: function(){SetTo_Form_Caller_Pddk();}
		}
  ]
	});
		
	var cbGrid_Search_RefPgwPddk = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefPgwPddk = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefPgwPddk', store: Data_Search_RefPgwPddk, frame: true, border: true, loadMask: true,
  	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPgwPddk, columnLines: true,
  	invalidateScrollerOnRefresh: false, 
		columns: [
  		{header: "Nama Pendidikan", dataIndex: 'nama_pddk', width: 290},
  		{header: "Jenjang", dataIndex: 'nama_jenjang_pddk', width: 100},
  		{header: "Lulus", dataIndex: 'tahun_lulus', width: 50}
  	], bbar: tbSearch_RefPgwPddk,
  	dockedItems: [{
  		xtype: 'pagingtoolbar', store: Data_Search_RefPgwPddk, dock: 'bottom', displayInfo: true
  	}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_PgwPddk').handler.call(Ext.getCmp("PILIH_PgwPddk").scope);
  		}
  	}  	
	});
	
	var win_popup_RefPgwPddk = new Ext.create('widget.window', {
   	id: 'win_popup_RefPgwPddk', title: 'Pendidikan Pegawai', iconCls: 'icon-toga',
   	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefPgwPddk]
	});

var new_popup_ref = win_popup_RefPgwPddk;

// POPUP REFERENSI PENDIDIKAN ---------------------------------------------------- END

// FUNCTION REF PENDIDIKAN ------------------------------------------------------- START 
function Funct_win_popup_RefPgwPddk(form_name, vfmode){
	Str_Cur_Form_Caller_Pddk = form_name;
	Cur_Form_Caller_Pddk = window[form_name];
	fmode = vfmode;
	win_popup_RefPgwPddk.show();
}

function SetTo_Form_Caller_Pddk(value_form){
	var sm = grid_Search_RefPgwPddk.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_pddk:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk'), tahun_lulus:sel[0].get('tahun_lulus')};
				break;
			case 2:
				var value_form = {kode_pddk_pmkg:sel[0].get('kode_pddk'), nama_pddk_pmkg:sel[0].get('nama_pddk'), tahun_lulus:sel[0].get('tahun_lulus')};
				break;
			default:
				var value_form = {kode_pddk:sel[0].get('kode_pddk'), nama_pddk:sel[0].get('nama_pddk'), tahun_lulus:sel[0].get('tahun_lulus')};
		}
	  Cur_Form_Caller_Pddk.getForm().setValues(value_form);
	  
	  win_popup_RefPgwPddk.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PENDIDIKAN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>