<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Fung = '', Cur_Form_Caller_Fung = '', fmode = '';

// POPUP REFERENSI TUGAS FUNGSIONAL ---------------------------------------------------- START
	Ext.define('MSearch_RefFung', {extend: 'Ext.data.Model',
    fields: ['ID_FT', 'kode_fung_tertentu', 'nama_fung_tertentu', 'kode_fung', 'nama_fung', 'jns_fung']
	});
	var Reader_Search_RefFung = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefFung', root: 'results', totalProperty: 'total', idProperty: 'ID_FT'  	
	});
	var Proxy_Search_RefFung = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_fung_tertentu', actionMethods: {read:'POST'}, extraParams :{id_open: '1'}, reader: Reader_Search_RefFung
	});
	var Data_Search_RefFung = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefFung', model: 'MSearch_RefFung', pageSize: 10,	noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefFung
	});

	var Search_RefFung = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefFung', store: Data_Search_RefFung, emptyText: 'Ketik di sini untuk pencarian', width: 380});
	var tbSearch_RefFung = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefFung',
	items:[
		Search_RefFung, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_FungTertentu',
		 handler: function(){SetTo_Form_Caller_Fung();}
		}
  ]
	});
	
	var cbGrid_Search_RefFung = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefFung = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefFung', store: Data_Search_RefFung, frame: true, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefFung, columnLines: true, invalidateScrollerOnRefresh: false,
		columns: [
  		{header: "Jenis", dataIndex: 'jns_fung', width: 100},
  		{header: "Nama Fungsional", dataIndex: 'nama_fung', width: 200},
  		{header: "Nama Fungsional Tertentu", dataIndex: 'nama_fung_tertentu', width: 200}
  	], bbar: tbSearch_RefFung,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefFung, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_FungTertentu').handler.call(Ext.getCmp("PILIH_FungTertentu").scope);
  		}
  	}  	
	});

	var win_popup_RefFung = new Ext.create('widget.window', {
   	id: 'win_popup_RefFung', title: 'Referensi Tugas Fungsional', iconCls: 'icon-templates',
   	modal:true, plain:true, closable: true, width: 600, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefFung]
	});	

var new_popup_ref = win_popup_RefFung;

// POPUP REFERENSI TUGAS FUNGSIONAL ---------------------------------------------------- END

// FUNCTION REF TUGAS FUNGSIONAL ------------------------------------------------------- START 
function Funct_win_popup_RefFung(form_name, vfmode){
	Str_Cur_Form_Caller_Fung = form_name;
	Cur_Form_Caller_Fung = window[form_name];
	fmode = vfmode;
	win_popup_RefFung.show();
}

function SetTo_Form_Caller_Fung(){
	var sm = grid_Search_RefFung.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
  				kode_fung_tertentu: sel[0].get('kode_fung_tertentu'),
  				nama_fung_tertentu: sel[0].get('nama_fung_tertentu'),
  				nama_fung: sel[0].get('nama_fung'),
  				jns_fung: sel[0].get('jns_fung')
  			};
				break;
			case 2:
				var value_form = {
	  			kode_fung_tertentu: sel[0].get('kode_fung_tertentu'),
	  			nama_fung_tertentu: sel[0].get('nama_fung_tertentu'),
	  			nama_fung: sel[0].get('nama_fung'),
	  			jns_fung: sel[0].get('jns_fung')
	  		}
				break;
			default:
				var value_form = {
	  			kode_fung_tertentu: sel[0].get('kode_fung_tertentu'),
	  			nama_fung_tertentu: sel[0].get('nama_fung_tertentu'),
	  			nama_fung: sel[0].get('nama_fung'),
	  			jns_fung: sel[0].get('jns_fung')
  			}
		}
	  Cur_Form_Caller_Fung.getForm().setValues(value_form);
	  
	  win_popup_RefFung.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF TUGAS FUNGSIONAL ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>