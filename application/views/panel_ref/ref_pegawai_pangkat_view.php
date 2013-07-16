<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Pangkat = '', Cur_Form_Caller_Pangkat = '', fmode = '';

// POPUP REFERENSI PANGKAT, GOLRU ---------------------------------------------------- START
	Ext.define('MSearch_RefPgwPangkat', {extend: 'Ext.data.Model',
    fields: ['IDP_Kpkt', 'kode_golru', 'nama_pangkat', 'nama_golru', 'TMT_kpkt', 'mk_th_kpkt', 'mk_bl_kpkt', 'gapok_kpkt']
	});
	var Reader_Search_RefPgwPangkat = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefPgwPangkat', root: 'results', totalProperty: 'total', idProperty: 'IDP_Kpkt'  	
	});	
	var Proxy_Search_RefPgwPangkat = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Search_RefPgwPangkat', url: BASE_URL + 'browse_ref/ext_get_all_pangkat_pgw', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefPgwPangkat
	});
	var Data_Search_RefPgwPangkat = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefPgwPangkat', model: 'MSearch_RefPgwPangkat', pageSize: 10, noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefPgwPangkat
	});

	var search_RefPgwPangkat = new Ext.create('Ext.ux.form.SearchField', {id: 'search_RefPgwPangkat', store: Data_Search_RefPgwPangkat, emptyText: 'Ketik di sini untuk pencarian', width: 380});
	var tbSearch_RefPgwPangkat = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPgwPangkat',
	items:[
		search_RefPgwPangkat, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_PgwPangkat',
		 handler: function(){SetTo_Form_Caller_Pangkat();}
		}
  ]
	});
		
	var cbGrid_Search_RefPgwPangkat = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefPgwPangkat = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefPgwPangkat', store: Data_Search_RefPgwPangkat, frame: true, border: true, loadMask: true,
  	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPgwPangkat, columnLines: true,
  	invalidateScrollerOnRefresh: false, 
		columns: [
  		{header: "Pangkat", dataIndex: 'nama_pangkat', width: 250},
  		{header: "Golru", dataIndex: 'nama_golru', width: 100},
	  	{header: "TMT", dataIndex: 'TMT_kpkt', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
  	], bbar: tbSearch_RefPgwPangkat,
  	dockedItems: [{
  		xtype: 'pagingtoolbar', store: Data_Search_RefPgwPangkat, dock: 'bottom', displayInfo: true
  	}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_PgwPangkat').handler.call(Ext.getCmp("PILIH_PgwPangkat").scope);
  		}
  	}  	
	});
	
	var win_popup_RefPgwPangkat = new Ext.create('widget.window', {
   	id: 'win_popup_RefPgwPangkat', title: 'Pangkat, Golru Pegawai', iconCls: 'icon-gears',
   	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefPgwPangkat]
	});

var new_popup_ref = win_popup_RefPgwPangkat;

// POPUP REFERENSI PANGKAT, GOLRU ---------------------------------------------------- END

// FUNCTION REF PANGKAT, GOLRU ------------------------------------------------------- START 
function Funct_win_popup_RefPgwPangkat(form_name, vfmode){
	Str_Cur_Form_Caller_Pangkat = form_name;
	Cur_Form_Caller_Pangkat = window[form_name];
	fmode = vfmode;
	win_popup_RefPgwPangkat.show();
}

function SetTo_Form_Caller_Pangkat(value_form){
	var sm = grid_Search_RefPgwPangkat.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
					kode_golru:sel[0].get('kode_golru'), 
					nama_pangkat:sel[0].get('nama_pangkat'), 
					nama_golru:sel[0].get('nama_golru')
				};
				break;
			case 2:
				var value_form = {
					kode_golru:sel[0].get('kode_golru'), 
					nama_pangkat:sel[0].get('nama_pangkat'), 
					nama_golru:sel[0].get('nama_golru'),
					mk_th_lama:sel[0].get('mk_th_kpkt'),
					mk_bl_lama:sel[0].get('mk_bl_kpkt'),
					gapok_lama:sel[0].get('gapok_kpkt')
				};
				break;
			default:
				var value_form = {
					kode_golru:sel[0].get('kode_golru'), 
					nama_pangkat:sel[0].get('nama_pangkat'), 
					nama_golru:sel[0].get('nama_golru'),
					mk_th_lama:sel[0].get('mk_th_kpkt'),
					mk_bl_lama:sel[0].get('mk_bl_kpkt'),
					gapok_lama:sel[0].get('gapok_kpkt')
				};
		}
	  Cur_Form_Caller_Pangkat.getForm().setValues(value_form);
	  
	  win_popup_RefPgwPangkat.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF PANGKAT, GOLRU ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>