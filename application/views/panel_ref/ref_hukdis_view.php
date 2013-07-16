<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var Str_Cur_Form_Caller_HukDis = '', Cur_Form_Caller_HukDis = '', fmode = '';
var vaktif = 1;

// POPUP REFERENSI HUKUMAN DISIPLIN ---------------------------------------------------- START
Ext.define('MSearch_RefHukDis', {extend: 'Ext.data.Model',
  fields: ['ID_HukDis', 'kode_hukdis', 'nama_hukdis', 'tkt_hukdis', 'pp']
});
var Reader_Search_RefHukDis = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefHukDis', root: 'results', totalProperty: 'total', idProperty: 'ID_HukDis'  	
});	
var Proxy_Search_RefHukDis = new Ext.create('Ext.data.AjaxProxy', {
  id: 'Proxy_Search_RefHukDis', url: BASE_URL + 'browse_ref/ext_get_all_hukdis', actionMethods: {read:'POST'},  extraParams :{id_open: '1'}, reader: Reader_Search_RefHukDis
});
var Data_Search_RefHukDis = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefHukDis', model: 'MSearch_RefHukDis', pageSize: 10, noCache: false, autoLoad: true,
   proxy: Proxy_Search_RefHukDis
});

var Search_RefHukDis = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefHukDis', store: Data_Search_RefHukDis, emptyText: 'Ketik di sini untuk pencarian', width: 270});
var tbSearch_RefHukDis = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefHukDis',
	items:[
    {xtype: 'checkbox', boxLabel: 'Aktif', id: 'cbstatus_data_hukdis', checked:true, margins: '0 10px 5px 5px', width: 50,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			vaktif = 1;
   	 		}else{
   	 			vaktif = 0;
   	 		}
   	 		setParams_Data_Search_RefHukDis(vaktif);
   	 	}
		 }
    }, 
		Search_RefHukDis, '->', 
		{text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_HukDis',
		 handler: function(){SetTo_Form_Caller_HukDis();}
		},'-',
		{text: 'Clear', iconCls: 'icon-cross', tooltip: {text: 'Clear Filter'}, 
     handler: function () {
    	grid_Search_RefHukDis.filters.clearFilters();
     }
    }
  ]
});

var filters_Search_RefHukDis = new Ext.create('Ext.ux.grid.filter.Filter', {
  ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefHukDis,
  filters: [
   	{type: 'string', dataIndex: 'nama_hukdis'},
   	{type: 'string', dataIndex: 'pp'},
   	{type: 'string', dataIndex: 'tkt_hukdis'}
  ]
});
		
var cbGrid_Search_RefHukDis = new Ext.create('Ext.selection.CheckboxModel');
var grid_Search_RefHukDis = new Ext.create('Ext.grid.Panel', {
	id: 'grid_Search_RefHukDis', store: Data_Search_RefHukDis, frame: true, border: true, loadMask: true,
 	style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefHukDis, columnLines: true,
 	invalidateScrollerOnRefresh: false, 
	columns: [
 		{header: "Nama Disiplin", dataIndex: 'nama_hukdis', width: 200},
 		{header: "PP", dataIndex: 'pp', width: 100},
 		{header: "Tingkat", dataIndex: 'tkt_hukdis', width: 80}
 	], bbar: tbSearch_RefHukDis, features: [filters_Search_RefHukDis],
 	dockedItems: [{
 		xtype: 'pagingtoolbar', store: Data_Search_RefHukDis, dock: 'bottom', displayInfo: true
 	}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_HukDis').handler.call(Ext.getCmp("PILIH_HukDis").scope);
 		}
 	}
});

var win_popup_RefHukDis = new Ext.create('widget.window', {
 	id: 'win_popup_RefHukDis', title: 'Referensi Disiplin', iconCls: 'icon-law',
 	modal:true, plain:true, closable: true, width: 500, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [grid_Search_RefHukDis]
});
	
var new_popup_ref = win_popup_RefHukDis;

// POPUP REFERENSI HUKUMAN DISIPLIN ---------------------------------------------------- END

// FUNCTION REF HUKUMAN DISIPLIN ------------------------------------------------------- START 
function Funct_win_popup_RefHukDis(form_name, vfmode){
	Str_Cur_Form_Caller_HukDis = form_name;
	Cur_Form_Caller_HukDis = window[form_name];
	fmode = vfmode;
	win_popup_RefHukDis.show();
}

function SetTo_Form_Caller_HukDis(){
	var sm = grid_Search_RefHukDis.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		switch(fmode){
			case 1:
				var value_form = {kode_hukdis:sel[0].get('kode_hukdis'), nama_hukdis:sel[0].get('nama_hukdis')};
				break;
			default:
				var value_form = {kode_hukdis:sel[0].get('kode_hukdis'), nama_hukdis:sel[0].get('nama_hukdis')};
		}
	  Cur_Form_Caller_HukDis.getForm().setValues(value_form);
	  
	  win_popup_RefHukDis.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefHukDis(p_aktif){
	Search_RefHukDis.onTrigger1Click();
	Data_Search_RefHukDis.changeParams({params :{id_open: 1, aktif: p_aktif}});
}

// FUNCTION REF HUKUMAN DISIPLIN ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>