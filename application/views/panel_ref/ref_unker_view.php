<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_UnKer = '', Cur_Form_Caller_UnKer = '', fmode = '';
var vaktif = 1, vnon_eselon = 1;

// POPUP REFERENSI UNIT KERJA ---------------------------------------------------- START
Ext.define('MSearch_RefUnKer', {extend: 'Ext.data.Model',
   fields: ['ID_UK', 'kode_unker', 'nama_unker']
});
var Reader_Search_RefUnKer = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefUnKer', root: 'results', totalProperty: 'total', idProperty: 'ID_UK'  	
});
var Proxy_Search_RefUnKer = new Ext.create('Ext.data.AjaxProxy', {
   url: BASE_URL + 'browse_ref/ext_get_all_unker', actionMethods: {read:'POST'},  extraParams :{id_open: 1, aktif: vaktif, non_eselon: vnon_eselon}, reader: Reader_Search_RefUnKer
});
var Data_Search_RefUnKer = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefUnKer', model: 'MSearch_RefUnKer', pageSize: 10, noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefUnKer
});

var Search_RefUnKer = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefUnKer', store: Data_Search_RefUnKer, emptyText: 'Ketik di sini untuk pencarian', width: 270});
var tbSearch_RefUnKer = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefUnKer',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_unor', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefUnKer(vaktif);
   	 	}
		 }
    },		
		Search_RefUnKer, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_UnKer',
		 handler: function(){SetTo_Form_Caller_UnKer();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefUnKer.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefUnKer = new Ext.create('Ext.ux.grid.filter.Filter', {
	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefUnKer,
  filters: [
   	{type: 'string', dataIndex: 'nama_unker'}
  ]
});

var cbGrid_Search_RefUnKer = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefUnKer = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefUnKer', store: Data_Search_RefUnKer, frame: true, noCache: false, border: true, loadMask: true, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefUnKer, columnLines: true,
	columns: [
 		{header: "NAMA UNIT KERJA", dataIndex: 'nama_unker', width: 420}
 	], bbar: tbSearch_RefUnKer, features: [filters_Search_RefUnKer],
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefUnKer, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_UnKer').handler.call(Ext.getCmp("PILIH_UnKer").scope);
 		}
 	}  	
});

var win_popup_RefUnKer = new Ext.create('widget.window', {
 	id: 'win_popup_RefUnKer', title: 'Referensi Unit Kerja', iconCls: 'icon-course',
 	modal:true, plain:true, closable: true, width: 500, height: 450, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefUnKer]
});

var new_popup_ref = win_popup_RefUnKer;

// POPUP REFERENSI UNIT KERJA ---------------------------------------------------- END

// FUNCTION REF UNIT KERJA ------------------------------------------------------- START 
function Funct_win_popup_RefUnKer(form_name, p_fmode){
	Str_Cur_Form_Caller_UnKer = form_name;
	Cur_Form_Caller_UnKer = window[form_name];
	fmode = p_fmode;
	win_popup_RefUnKer.show();
}

function SetTo_Form_Caller_UnKer(){
	var sm = grid_Search_RefUnKer.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {
  				kode_unker: sel[0].get('kode_unker'),
  				nama_unker: sel[0].get('nama_unker')
			  };
			  break;
			case 2:
				var value_form = {
  				kode_unker_filter: sel[0].get('kode_unker'),
  				nama_unker_filter: sel[0].get('nama_unker')
			  };
			  break;
			case 3:
				// Tugas Belajar
				var value_form = {
  				kode_unker_pemohon: sel[0].get('kode_unker'),
  				nama_unker_pemohon: sel[0].get('nama_unker')
			  };
			  break;
			default:
				var value_form = {
  				kode_unker: sel[0].get('kode_unker'),
  				nama_unker: sel[0].get('nama_unker')
			  };
		}
	  Cur_Form_Caller_UnKer.getForm().setValues(value_form);
	  
	  win_popup_RefUnKer.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefUnKer(p_aktif, p_non_eselon){
	Search_RefUnKer.onTrigger1Click();
	Data_Search_RefUnKer.changeParams({params :{id_open: 1, aktif: p_aktif}});
}

// FUNCTION REF UNIT KERJA ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>