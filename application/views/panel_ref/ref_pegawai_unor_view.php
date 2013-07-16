<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller = '', Cur_Form_Caller = '', fmode = '';

// POPUP REFERENSI UNIT ORGANISASI ---------------------------------------------------- START
	Ext.define('MSearch_RefPgwUnor', {extend: 'Ext.data.Model',
    fields: ['IDP_Jab', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_jab', 'nama_jab', 'klp_jab', 'TMT_jab']
	});
	var Reader_Search_RefPgwUnor = new Ext.create('Ext.data.JsonReader', {
  	id: 'Reader_Search_RefPgwUnor', root: 'results', totalProperty: 'total', idProperty: 'IDP_Jab'  	
	});
	var Proxy_Search_RefPgwUnor = new Ext.create('Ext.data.AjaxProxy', {
    url: BASE_URL + 'browse_ref/ext_get_all_unor_pgw', actionMethods: {read:'POST'},  extraParams :{id_open: 1}, reader: Reader_Search_RefPgwUnor
	});
	var Data_Search_RefPgwUnor = new Ext.create('Ext.data.Store', {
		id: 'Data_Search_RefPgwUnor', model: 'MSearch_RefPgwUnor', pageSize: 10, noCache: false, autoLoad: true,
    proxy: Proxy_Search_RefPgwUnor
	});

var Search_RefPgwUnor = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPgwUnor', store: Data_Search_RefPgwUnor, emptyText: 'Ketik di sini untuk pencarian', width: 480});
var tbSearch_RefPgwUnor = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPgwUnor',
	items:[
		Search_RefPgwUnor, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_PgwUnor',
		 handler: function(){SetTo_Form_Caller_Unor();}
		}
  ]
});

	var cbGrid_Search_RefPgwUnor = new Ext.create('Ext.selection.CheckboxModel');
	var grid_Search_RefPgwUnor = new Ext.create('Ext.grid.Panel', {
		id: 'grid_Search_RefPgwUnor', store: Data_Search_RefPgwUnor, frame: true, noCache: false, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPgwUnor, columnLines: true,
		columns: [
  		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 200},
  		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 200},
  		{header: "Jabatan", dataIndex: 'nama_jab', width: 150},
  		{header: "TMT Jabatan", dataIndex: 'TMT_jab', width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
  	], bbar: tbSearch_RefPgwUnor,
  	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPgwUnor, dock: 'bottom', displayInfo: true}],
  	listeners: {
  		itemdblclick: function(dataview, record, item, index, e) {
  			Ext.getCmp('PILIH_PgwUnor').handler.call(Ext.getCmp("PILIH_PgwUnor").scope);
  		}
  	}  	
	});

	var win_popup_RefPgwUnor = new Ext.create('widget.window', {
   	id: 'win_popup_RefPgwUnor', title: 'Unor Organisasi Pegawai', iconCls: 'icon-gears',
   	modal:true, plain:true, closable: true, width: 700, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
   	items: [grid_Search_RefPgwUnor]
	});

var new_popup_ref = win_popup_RefPgwUnor;

// POPUP REFERENSI UNIT ORGANISASI ---------------------------------------------------- END

// FUNCTION REF UNIT ORGANISASI ------------------------------------------------------- START 
function Funct_win_popup_RefPgwUnor(form_name, vfmode){
	Str_Cur_Form_Caller = form_name;
	Cur_Form_Caller = window[form_name];
	fmode = vfmode;
	win_popup_RefPgwUnor.show();
}

function SetTo_Form_Caller_Unor(){
	var sm = grid_Search_RefPgwUnor.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
  				kode_unor: sel[0].get('kode_unor'),
  				nama_unor: sel[0].get('nama_unor'),
  				nama_unker: sel[0].get('nama_unker'),
  				kode_jab: sel[0].get('kode_jab'),
  				nama_jab: sel[0].get('nama_jab'),
  				TMT_jab_lama: sel[0].get('TMT_jab')
			  };
			  break;
			case 2:
				var value_form = {
  				kode_unor_baru: sel[0].get('kode_unor'),
  				nama_unor_baru: sel[0].get('nama_unor'),
  				nama_unker_baru: sel[0].get('nama_unker'),
  				kode_jab_baru: sel[0].get('kode_jab'),
  				nama_jab_baru: sel[0].get('nama_jab')
			  };
			  break;
			case 3:
				var value_form = {
  				kode_unor_lama: sel[0].get('kode_unor'),
  				nama_unor_lama: sel[0].get('nama_unor'),
  				nama_unker_lama: sel[0].get('nama_unker'),
  				kode_jab_lama: sel[0].get('kode_jab'),
  				nama_jab_lama: sel[0].get('nama_jab')
			  };
			  break;
			case 4:
				var value_form = {
  				kode_unor_pmkg: sel[0].get('kode_unor'),
  				nama_unor_pmkg: sel[0].get('nama_unor'),
  				nama_unker_pmkg: sel[0].get('nama_unker'),
  				kode_jab_pmkg: sel[0].get('kode_jab'),
  				nama_jab_pmkg: sel[0].get('nama_jab')
			  };
			  break;
			case 5:
				var value_form = {
  				kode_unor_usul: sel[0].get('kode_unor'),
  				nama_unor_usul: sel[0].get('nama_unor'),
  				nama_unker_usul: sel[0].get('nama_unker'),
  				kode_jab_usul: sel[0].get('kode_jab'),
  				nama_jab_usul: sel[0].get('nama_jab')
			  };
			  break;
			case 6:
				var value_form = {
  				kode_unor: sel[0].get('kode_unor'),
  				nama_unor: sel[0].get('nama_unor'),
  				nama_unker: sel[0].get('nama_unker'),
  				kode_jab: sel[0].get('kode_jab'),
  				nama_jab: sel[0].get('nama_jab'),
  				klp_jab: sel[0].get('klp_jab')
			  };
			  break;
			default:
				var value_form = {
  				kode_unor: sel[0].get('kode_unor'),
  				nama_unor: sel[0].get('nama_unor'),
  				nama_unker: sel[0].get('nama_unker'),
  				kode_jab: sel[0].get('kode_jab'),
  				nama_jab: sel[0].get('nama_jab')
			  };
		}
	  Cur_Form_Caller.getForm().setValues(value_form);
	  
	  win_popup_RefPgwUnor.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}
// FUNCTION REF UNIT ORGANISASI ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>