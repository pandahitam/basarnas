<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_Unor = '', Cur_Form_Caller_Unor = '', fmode = '';
var vaktif = 1, veselon = 0;

// POPUP REFERENSI UNIT ORGANISASI ---------------------------------------------------- START
Ext.define('MSearch_RefUnor', {extend: 'Ext.data.Model',
   fields: ['ID_Unor', 'kode_unor', 'nama_unor', 'kode_eselon', 'nama_eselon', 'nama_unker']
});
var Reader_Search_RefUnor = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefUnor', root: 'results', totalProperty: 'total', idProperty: 'ID_Unor'  	
});
var Proxy_Search_RefUnor = new Ext.create('Ext.data.AjaxProxy', {
   url: BASE_URL + 'browse_ref/ext_get_all_unor', actionMethods: {read:'POST'},  extraParams :{id_open: 1, aktif: vaktif, eselon: veselon}, reader: Reader_Search_RefUnor
});
var Data_Search_RefUnor = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefUnor', model: 'MSearch_RefUnor', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefUnor
});

var Search_RefUnor = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefUnor', store: Data_Search_RefUnor, emptyText: 'Ketik di sini untuk pencarian', width: 280});
var tbSearch_RefUnor = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefUnor',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_unor', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefUnor(vaktif, veselon);
   	 	}
		 }
    },		
    {xtype: 'checkbox', boxLabel: 'Eselon', id: 'cbeselon_unor', checked:false, margins: '0 5px 5px 5px', width: 70,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			veselon = 1;
   	 		}else{
   	 			veselon = 0;
   	 		}
   	 		setParams_Data_Search_RefUnor(vaktif, veselon);
   	 	}
		 }
    },		
		Search_RefUnor, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_Unor',
		 handler: function(){SetTo_Form_Caller_Unor();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefUnor.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefUnor = new Ext.create('Ext.ux.grid.filter.Filter', {
	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefUnor,
  filters: [
   	{type: 'string', dataIndex: 'nama_unor'},
   	{type: 'string', dataIndex: 'nama_unker'}
  ]
});

var cbGrid_Search_RefUnor = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefUnor = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefUnor', store: Data_Search_RefUnor, frame: true, noCache: false, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefUnor, columnLines: true,
	columns: [
 		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 320},
 		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 220}
 	], bbar: tbSearch_RefUnor, features: [filters_Search_RefUnor],
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefUnor, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_Unor').handler.call(Ext.getCmp("PILIH_Unor").scope);
 		}
 	}  	
});

var win_popup_RefUnor = new Ext.create('widget.window', {
 	id: 'win_popup_RefUnor', title: 'Referensi Unit Organisasi', iconCls: 'icon-spell',
 	modal:true, plain:true, closable: true, width: 600, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefUnor]
});

var new_popup_ref = win_popup_RefUnor;

// POPUP REFERENSI UNIT ORGANISASI ---------------------------------------------------- END

// FUNCTION REF UNIT ORGANISASI ------------------------------------------------------- START 
function Funct_win_popup_RefUnor(form_name, p_fmode){
	Str_Cur_Form_Caller_Unor = form_name;
	Cur_Form_Caller_Unor = window[form_name];
	fmode = p_fmode;
	win_popup_RefUnor.show();
}

function SetTo_Form_Caller_Unor(){
	var sm = grid_Search_RefUnor.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 'usul':
				var value_form = {
  				kode_unor_usul: sel[0].get('kode_unor'),
  				nama_unor_usul: sel[0].get('nama_unor'),
  				nama_unker_usul: sel[0].get('nama_unker')
			  };
			  break;
			case 1:
				var value_form = {
  				kode_unor: sel[0].get('kode_unor'),
  				nama_unor: sel[0].get('nama_unor'),
  				nama_unker: sel[0].get('nama_unker'),
  				kode_eselon: sel[0].get('kode_eselon'),
  				nama_eselon: sel[0].get('nama_eselon')
			  };
			  break;
			case 2:
				var value_form = {
  				kode_unor_baru: sel[0].get('kode_unor'),
  				nama_unor_baru: sel[0].get('nama_unor'),
  				nama_unker_baru: sel[0].get('nama_unker')
			  };
			  break;
			case 3:
				var value_form = {
  				kode_unor_lama: sel[0].get('kode_unor'),
  				nama_unor_lama: sel[0].get('nama_unor'),
  				nama_unker_lama: sel[0].get('nama_unker')
			  };
			  break;
			case 4:
				var value_form = {
  				kode_unor_pmkg: sel[0].get('kode_unor'),
  				nama_unor_pmkg: sel[0].get('nama_unor'),
  				nama_unker_pmkg: sel[0].get('nama_unker')
			  };
			  break;
			default:
				var value_form = {
  				kode_unor: sel[0].get('kode_unor'),
  				nama_unor: sel[0].get('nama_unor'),
  				nama_unker: sel[0].get('nama_unker'),
  				kode_eselon: sel[0].get('kode_eselon'),
  				nama_eselon: sel[0].get('nama_eselon')
			  };
		}
	  Cur_Form_Caller_Unor.getForm().setValues(value_form);
	  
	  win_popup_RefUnor.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefUnor(p_aktif, p_eselon){
	Search_RefUnor.onTrigger1Click();
	Data_Search_RefUnor.changeParams({params :{id_open: 1, aktif: p_aktif, eselon: p_eselon}});
}

// FUNCTION REF UNIT ORGANISASI ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>